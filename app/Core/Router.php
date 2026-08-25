<?php

declare(strict_types=1);

namespace App\Core;

class Router
{
  private array $routes = [];
  private string $lastMethod;
  private string $lastUri;

  public function __construct(private Container $container) {}

  private function add(string $method, string $uri, array $handler): void
  {
    $this->routes[$method][$uri] = [
      'handler' => $handler,
      'middleware' => null,
    ];

    $this->lastMethod = $method;
    $this->lastUri = $uri;
  }

  public function dispatch(string $httpMethod, string $uri): void
  {
    $route = $this->routes[$httpMethod][$uri] ?? null;
    $params = [];

    if ($route === null) {
      $match = $this->matchDynamicRoute($httpMethod, $uri);

      if ($match !== null) {
        $route = $match['route'];
        $params = $match['params'];
      }
    }

    if ($route === null) {
      http_response_code(404);
      view('errors/404');
      return;
    }

    $middleware = $route['middleware'];

    if ($middleware === 'guest' && isAuthenticated())
      redirect('/');

    if ($middleware === 'auth' && !isAuthenticated())
      redirect('/login');

    if ($httpMethod === 'POST') {
      verifyCsrfToken();
    }

    [$controllerClass, $controllerMethod] = $route['handler'];

    $controller = $this->container->resolve($controllerClass);
    $controller->$controllerMethod(...$params);
  }

  private function matchDynamicRoute(string $httpMethod, string $uri): ?array
  {
    $uriSegments = explode('/', trim($uri, '/'));

    foreach ($this->routes[$httpMethod] ?? [] as $route => $routeHandler) {
      $routeSegments = explode('/', trim($route, '/'));

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
        return [
          'route' => $routeHandler,
          'params' => $routeParams,
        ];
      }
    }

    return null;
  }

  public function middleware(?string $middleware = null): self
  {
    $this->routes[$this->lastMethod][$this->lastUri]['middleware'] = $middleware;

    return $this;
  }

  public function get(string $uri, array $handler): self
  {
    $this->add('GET', $uri, $handler);

    return $this;
  }

  public function post(string $uri, array $handler): self
  {
    $this->add('POST', $uri, $handler);

    return $this;
  }
}
