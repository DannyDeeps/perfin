<?php declare(strict_types=1);

namespace Perfin\Core\Routing;

class Route {
  public function __construct(
    public string $method,
    public string $path,
    public string $controller,
    public string $action,
    public array $params = []
  ) {
  }

  public function matches(string $method, string $uri): bool {
    $pathParts = explode('/', $this->path);
    $uriParts = explode('/', $uri);

    if (count($pathParts) !== count($uriParts)) {
      return false;
    }

    foreach ($pathParts as $i => $part) {
      if ($part === $uriParts[$i]) {
        continue;
      }

      if (str_contains($part, '#') && ctype_digit($uriParts[$i])) {
        $this->params[substr($part, 1)] = (int) $uriParts[$i];
        continue;
      }

      if (str_contains($part, ':')) {
        $this->params[substr($part, 1)] = $uriParts[$i];
        continue;
      }

      return false;
    }

    return $this->method === strtoupper($method);
  }
}