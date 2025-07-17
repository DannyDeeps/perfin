<?php declare(strict_types=1);

namespace Perfin\Core\Util;

final class Cryptography {
  public static function normaliseAndHashArray(array $array): string {
    return self::hash(implode(',', array_map('trim', $array)));
  }

  public static function hash(string $hashKey): string {
    return bin2hex(substr(hash('sha256', $hashKey, true), 0, 16));
  }

  public static function verify(string $hashKey, string $hash): bool {
    return hash_equals($hash, self::hash($hashKey));
  }
}