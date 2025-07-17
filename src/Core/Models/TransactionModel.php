<?php declare(strict_types=1);

namespace Perfin\Core\Models;

use \PDO;

class TransactionModel extends AbstractModel {
  public static function create(
    string $id,
    int $transactionDate,
    string $type,
    string $sortCode,
    int $accountNumber,
    string $description,
    float $debitAmount,
    float $creditAmount,
    float $balance,
  ): array|false {
    $db = self::connect();

    try {
      $stmt = $db->prepare(
        "INSERT OR IGNORE INTO transactions (
          id,
          transaction_date,
          type,
          sort_code,
          account_number,
          description,
          debit_amount,
          credit_amount,
          balance
        ) VALUES (
          :id,
          :transaction_date,
          :type,
          :sort_code,
          :account_number,
          :description,
          :debit_amount,
          :credit_amount,
          :balance
        ) RETURNING *;"
      );

      $stmt->execute([
        ':id'               => $id,
        ':transaction_date' => $transactionDate,
        ':type'             => $type,
        ':sort_code'        => $sortCode,
        ':account_number'   => $accountNumber,
        ':description'      => $description,
        ':debit_amount'     => $debitAmount,
        ':credit_amount'    => $creditAmount,
        ':balance'          => $balance
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
      $stmt = $db->prepare("SELECT * FROM transactions WHERE id = :id");
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
      $stmt = $db->prepare('DELETE FROM transactions WHERE id = :id RETURNING *');
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
      $stmt = $db->query('SELECT * FROM transactions');

      return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    } catch (\PDOException $e) {
      echo '<pre>' . print_r($e, true) . '</pre>';
      return [];
    }
  }

  public static function count(): int {
    $db = self::connect();

    try {
      $stmt = $db->query('SELECT COUNT(*) FROM transactions');
      return $stmt->fetchColumn();
    } catch (\PDOException $e) {
      echo '<pre>' . print_r($e, true) . '</pre>';
      return 0;
    }
  }

  public static function truncate(): bool {
    $db = self::connect();

    try {
      $db->query('DELETE FROM transactions');
      return true;
    } catch (\PDOException $e) {
      echo '<pre>' . print_r($e, true) . '</pre>';
      return false;
    }
  }
}