<?php

declare(strict_types=1);

namespace zzt\Core;

use zzt\Exception\RouterException;
use zzt\router\Type;

class Router
{
  private static $instance;

  private $routes = [
    'GET' => [],
    'POST' => []
  ];

  private function __construct()
  {
  }

  public static function getInstance(): Router
  {
    if (self::$instance === null) {
      self::$instance = new self();
    }
    return self::$instance;
  }

  public function add(Type $type, string $route, $callback): void
  {
    if (!array_key_exists($type->name, $this->routes)) {
      throw new RouterException('Http type not supported: ' . $type->name);
    }

    $this->routes[$type->name][$route] = $callback;
  }

  public function get(Type $type, string $route): ?callable
  {
    return $this->routes[$type->name][$route];
  }
}
