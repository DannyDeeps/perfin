<?php declare(strict_types=1);

namespace Perfin\Transaction;

use \Perfin\Core\Routing\Router;

final class TransactionRoutes {
  public static function register(Router $router): void {
    $router->addRoute('GET', '/transactions', TransactionViewController::class, 'transactions');

    $router->addRoute('GET', '/api/transactions', TransactionApiController::class, 'all');
    $router->addRoute('POST', '/api/transaction', TransactionApiController::class, 'create');
    $router->addRoute('GET', '/api/transaction/:hash', TransactionApiController::class, 'read');
    $router->addRoute('PUT', '/api/transaction/:hash', TransactionApiController::class, 'update');
    $router->addRoute('DELETE', '/api/transaction/:hash', TransactionApiController::class, 'delete');
    $router->addRoute('POST', '/api/transactions/upload', TransactionApiController::class, 'csvUpload');
  }
}