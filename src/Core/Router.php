<?php

declare(strict_types=1);

namespace zzt\Core;

use zzt\router\Type;

class Router
{
  private static $instance;

  private $get = [];
  private $post = [];

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
    match ($type->name) {
      Type::GET->name => $this->get[$route] = $callback,
      Type::POST->name => $this->post[$route] = $callback,
      default => null,
    };
  }

  public function get(Type $type, string $route): ?callable
  {
    $res = match ($type->name) {
      Type::GET->name => $this->get[$route] ?? null,
      Type::POST->name => $this->get[$route] ?? null,
      default => null,
    };

    return $res;
  }
}