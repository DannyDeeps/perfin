<?php declare(strict_types=1);

namespace Perfin\Core\Routing;

class Router {
  private array $routes = [];

  public function addRoute(
    string $method,
    string $path,
    string $controller,
    string $action,
    array $params = []
  ): void {
    $this->routes[] = new Route(
      $method,
      $path,
      $controller,
      $action,
      $params
    );
  }

  public function dispatch(string $method, string $uri): void {
    // die('<pre>' . print_r([$method, $uri], true) . '</pre>');
    foreach ($this->routes as $route) {
      if ($route->matches($method, $uri)) {
        // die('<pre>' . print_r($route, true) . '</pre>');
        $controller = new $route->controller();
        $action = $route->action;

        if (!method_exists($controller, $action)) {
          http_response_code(404);
          echo 'Action not found';
          return;
        }

        $controller::$action($route);
        return;
      }
    }

    http_response_code(404);
    echo "Route not found: $uri";
  }
}