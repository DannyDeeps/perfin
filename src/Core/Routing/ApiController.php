<?php declare(strict_types=1);

namespace Perfin\Core\Routing;

class ApiController {
  protected static function parseJsonRequest(): array {
    return json_decode(file_get_contents('php://input'), true);
  }

  protected static function parseFormRequest(): array {
    return $_POST;
  }

  protected static function jsonResponse(mixed $payload, int $responseCode = 200): void {
    http_response_code($responseCode);
    header("Content-Type: application/json");
    echo json_encode($payload);
  }

  protected static function htmlResponse(string $htmlPayload, int $responseCode = 200): void {
    http_response_code($responseCode);
    header("Content-Type: text/html");
    echo $htmlPayload;
  }
}