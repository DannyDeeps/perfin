<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Perfin\Core\Util\Cryptography;

final class CryptographyTest extends TestCase {
  public function testNormaliseAndHashArray(): void {
    $this->assertSame(
      '9a38e561234bdebcecce8f6aa85c8973',
      Cryptography::normaliseAndHashArray(['  a', 'b', 'c', 'd '])
    );
  }

  public function testHash(): void {
    $this->assertSame(
      '9a38e561234bdebcecce8f6aa85c8973',
      Cryptography::hash('a,b,c,d')
    );
  }

  public function testVerify(): void {
    $hash = Cryptography::hash('a,b,c,d');
    $this->assertTrue(Cryptography::verify('a,b,c,d', $hash));
    $this->assertFalse(Cryptography::verify('x,y,z', $hash));
  }
}
