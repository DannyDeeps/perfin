<?php declare(strict_types=1);

namespace Perfin\Core\Models;

use \PDO;

abstract class AbstractModel {
  protected static function connect(): PDO {
    $dbFile = __DIR__ . '/../../../db/perfin.db';
    try {
      $db = PDO::connect("sqlite:$dbFile");
      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $db->exec('PRAGMA foreign_keys = ON;');
      return $db;
    } catch (\PDOException $e) {
     die($e->getMessage());
    }
  }
}
