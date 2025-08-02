<?php declare(strict_types=1);

namespace Perfin\Core\Models;

use \PDO;

class TransactionSourceMatchModel extends AbstractModel {
  public static function create(
    string $transactionId,
    int $sourceId,
    int $matcherId
  ): array|false {
    $db = self::connect();

    try {
      $stmt = $db->prepare(
        "INSERT OR IGNORE INTO source_matchers (
          transaction_id, source_id, matcher_id
        ) VALUES (
          :transaction_id, :source_id, :matcher_id
        ) RETURNING *;"
      );

      $stmt->execute([
        ':transaction_id'   => $transactionId,
        ':source_id' => $sourceId,
        ':matcher_id' => $matcherId
      ]);

      return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (\PDOException $e) {
      // die('<pre>' . print_r($e, true) . '</pre>');
      // Log error
      return false;
    }
  }

  public static function read(string $id): array {
    $db = self::connect();

    try {
      $stmt = $db->prepare("SELECT * FROM sources WHERE id = :id");
      $stmt->execute([':id'   => $id]);

      return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
    } catch (\PDOException $e) {
      echo '<pre>' . print_r($e, true) . '</pre>';
      return [];
    }
  }

  public static function delete(string $id): array {
    $db = self::connect();

    try {
      $stmt = $db->prepare('DELETE FROM sources WHERE id = :id RETURNING *');
      $stmt->execute([':id'   => $id]);

      return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
    } catch (\PDOException $e) {
      echo '<pre>' . print_r($e, true) . '</pre>';
      return [];
    }
  }

  public static function all(): array {
    $db = self::connect();

    try {
      $stmt = $db->query('SELECT * FROM sources');

      return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    } catch (\PDOException $e) {
      echo '<pre>' . print_r($e, true) . '</pre>';
      return [];
    }
  }

  public static function count(): int {
    $db = self::connect();

    try {
      $stmt = $db->query('SELECT COUNT(*) FROM sources');
      return $stmt->fetchColumn();
    } catch (\PDOException $e) {
      echo '<pre>' . print_r($e, true) . '</pre>';
      return 0;
    }
  }

  public static function truncate(): bool {
    $db = self::connect();

    try {
      $db->query('DELETE FROM sources');
      return true;
    } catch (\PDOException $e) {
      echo '<pre>' . print_r($e, true) . '</pre>';
      return false;
    }
  }
}