<?php declare(strict_types=1);

namespace Perfin\Source;

use \DateTime;
use Perfin\Core\Models\SourceModel;
use Perfin\Core\Routing\{ Route, ApiController };
use Perfin\Core\Util\Cryptography;

final class SourceApiController extends ApiController {
  public static function read(Route $route): void {
    try {
      // $wantsHtml = 'text/html' === ($_SERVER['HTTP_ACCEPT'] ?? '');

      $payload = SourceModel::read($route->params['id']);
      if (!$payload) {
        // if ($wantsHtml) {
        //   parent::htmlResponse('', 404);
        // } else {
          parent::jsonResponse([], 404);
        // }

        return;
      }

      // if ($wantsHtml) {
      //   parent::htmlResponse(
      //     new TemplateController()->engine
      //       ->render('shards/payload', [ 'payload' => $payload ])
      //   );
      // } else {
      //   parent::jsonResponse($payload);
      // }
    } catch (\Throwable $e) {
      parent::jsonResponse([], 500);
    }
  }

  public static function create(Route $route): void {
    try {
      // $wantsHtml = 'text/html' === ($_SERVER['HTTP_ACCEPT'] ?? '');

      $data = $_SERVER['CONTENT_TYPE'] === 'application/json'
        ? parent::parseJsonRequest()
        : parent::parseFormRequest();

      $newPayload = SourceModel::create(...$data);
      if (!$newPayload) {
        // if ($wantsHtml) {
        //   parent::htmlResponse('', 500);
        // } else {
          parent::jsonResponse([], 500);
        // }

        return;
      }

      // if ($wantsHtml) {
      //   parent::htmlResponse(
      //     new TemplateController()->engine
      //       ->render('shards/payload', [ 'payload' => $newPayload ])
      //   );
      // } else {
      //   parent::jsonResponse($newPayload);
      // }
    } catch (\Throwable $e) {
      parent::jsonResponse(['error' => print_r($e, true)], 500);
    }
  }

  public static function update(Route $route): void {
    try {
      // $wantsHtml = 'text/html' === ($_SERVER['HTTP_ACCEPT'] ?? '');

      $data = json_decode(file_get_contents('php://input'), true);

      $id = $route->params['id'];
      unset($data['id']);

      $updatedPayload = SourceModel::update($id, $data);
      if (!$updatedPayload) {
        // if ($wantsHtml) {
        //   parent::htmlResponse('', 404);
        // } else {
          parent::jsonResponse([], 404);
        // }

        return;
      }

      // if ($wantsHtml) {
      //   parent::htmlResponse(
      //     new TemplateController()->engine
      //       ->render('shards/payload', [ 'payload' => $updatedPayload ])
      //   );
      // } else {
      //   parent::jsonResponse($updatedPayload);
      // }
    } catch (\Throwable $e) {
      // d($e->getMessage());
      parent::jsonResponse([], 500);
    }
  }

  public static function delete(Route $route): void {
    try {
      // $wantsHtml = 'text/html' === ($_SERVER['HTTP_ACCEPT'] ?? '');

      $deletedPayload = SourceModel::delete($route->params['id']);
      if (!$deletedPayload) {
        // if ($wantsHtml) {
        //   parent::htmlResponse('', 404);
        // } else {
          parent::jsonResponse([], 404);
        // }

        return;
      }

      // if ($wantsHtml) {
      //   parent::htmlResponse('', 200);
      // } else {
      //   parent::jsonResponse($deletedPayload, 200);
      // }
    } catch (\Throwable $e) {
      // d($e->getMessage());
      parent::jsonResponse([], 500);
    }
  }

  public static function all(Route $route): void {
    try {
      // $wantsHtml = 'text/html' === ($_SERVER['HTTP_ACCEPT'] ?? '');

      $Sources = SourceModel::all();
      // die('<pre>' . print_r($Sources, true) . '</pre>');
      if (!$Sources) {
        // if ($wantsHtml) {
        //   parent::htmlResponse('', 404);
        // } else {
          parent::jsonResponse([], 404);
        // }

        return;
      }

      // if ($wantsHtml) {
      //   parent::htmlResponse(
      //     new TemplateController()->engine
      //       ->render('shards/payloads', [ 'Sources' => $Sources ])
      //   );
      // } else {
      parent::jsonResponse($Sources);
      // }
    } catch (\Throwable $e) {
      // d($e->getMessage());
      parent::jsonResponse([], 500);
    }
  }

  public static function csvUpload(Route $route): void {
    if (empty($_FILES['upload']) || $_FILES['upload']['error'] !== UPLOAD_ERR_OK) {
      parent::jsonResponse(['error' => 'Invalid file upload'], 400);
      return;
    }

    $csvFile = fopen($_FILES['upload']['tmp_name'], 'r');
    if (!$csvFile) {
      parent::jsonResponse(['error' => 'Failed to open CSV file'], 500);
      return;
    }

    fgetcsv($csvFile, null, ',', '"', "\\");

    $Sources = [];

    while (($csvLine = fgetcsv($csvFile, null, ',', '"', "\\")) !== false) {
      $Sources[] = [
        'id'               => Cryptography::normaliseAndHashArray($csvLine),
        'SourceDate' => DateTime::createFromFormat('d/m/Y', $csvLine[0])->getTimestamp(),
        'type'             => $csvLine[1],
        'sortCode'        => ltrim($csvLine[2], '\''),
        'accountNumber'   => (int) $csvLine[3],
        'description'      => $csvLine[4],
        'debitAmount'     => (float) $csvLine[5],
        'creditAmount'    => (float) $csvLine[6],
        'balance'          => (float) $csvLine[7]
      ];
    }

    fclose($csvFile);

    $insertedSources = [];
    foreach ($Sources as $Source) {
      $insertedSource = SourceModel::create(...$Source);
      if ($insertedSource) {
        $insertedSources[] = $insertedSource;
      }
    }

    if (count($insertedSources) === count($Sources)) {
      parent::jsonResponse([
        'Sources' => $insertedSources
      ], 201);
    } else {
      parent::jsonResponse([
        'error' => 'Some Sources were not inserted',
        'Sources' => $insertedSources
      ], 500);
    }
  }
}