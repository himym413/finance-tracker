<?php

declare(strict_types=1);

namespace App\Core;

class Router
{
  private array $routes = [];

  public function __construct(private Container $container)
  {
    $this->container = $container;
  }

  private function add(string $method, string $uri, array $handler): void
  {
    $this->routes[$method][$uri] = $handler;
  }

  public function dispatch(string $httpMethod, string $uri): void
  {
    $handler = $this->routes[$httpMethod][$uri] ?? null;
    $params = [];

    if ($handler === null) {
      foreach ($this->routes[$httpMethod] ?? [] as $route => $routeHandler) {
        $routeSegments = explode('/', trim($route, '/'));
        $uriSegments = explode('/', trim($uri, '/'));

        if (count($routeSegments) !== count($uriSegments)) {
          continue;
        }

        $matches = true;
        $routeParams = [];

        foreach ($routeSegments as $index => $segment) {
          $isParameter = str_starts_with($segment, '{')
            && str_ends_with($segment, '}');

          if ($isParameter) {
            $routeParams[] = $uriSegments[$index];
            continue;
          }

          if ($segment !== $uriSegments[$index]) {
            $matches = false;
            break;
          }
        }

        if ($matches) {
          $handler = $routeHandler;
          $params = $routeParams;
          break;
        }
      }
    }

    if ($handler === null) {
      http_response_code(404);
      echo '404 Not Found';
      return;
    }

    [$controllerClass, $controllerMethod] = $handler;

    $controller = $this->container->resolve($controllerClass);
    $controller->$controllerMethod(...$params);
  }

  public function get(string $uri, array $handler): void
  {
    $this->add('GET', $uri, $handler);
  }

  public function post(string $uri, array $handler): void
  {
    $this->add('POST', $uri, $handler);
  }
}
