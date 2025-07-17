<?php declare(strict_types=1);

namespace Perfin\Transaction;

use \Perfin\Core\Routing\Router;

final class TransactionViewRoutes {
  public static function register(Router $router): void {
    $router->addRoute('GET', '/transactions', TransactionViewController::class, 'transactions');
  }
}