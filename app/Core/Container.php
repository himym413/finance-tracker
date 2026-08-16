<?php

declare(strict_types=1);

namespace App\Core;

use ReflectionClass;
use RuntimeException;

class Container
{
  private array $bindings = [];

  public function bind(string $key, object $value): void
  {
    $this->bindings[$key] = $value;
  }

  public function resolve(string $class): object
  {
    if (isset($this->bindings[$class])) {
      return $this->bindings[$class];
    }

    $reflection = new ReflectionClass($class);
    $constructor = $reflection->getConstructor();

    if ($constructor === null) {
      return new $class();
    }

    $parameters = $constructor->getParameters();
    $dependencies = [];

    foreach ($parameters as $parameter) {
      $type = $parameter->getType();

      if ($type === null) {
        throw new RuntimeException(
          "Cannot resolve parameter [{$parameter->getName()}] in class [{$class}]."
        );
      }

      $dependencyClass = $type->getName();

      $dependencies[] = $this->resolve($dependencyClass);
    }

    return $reflection->newInstanceArgs($dependencies);
  }
}
