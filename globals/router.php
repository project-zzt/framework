<?php

declare(strict_types=1);

namespace zzt\router;

use zzt\Core\Router;

enum Type: string
{
  case GET = 'GET';
  case POST = 'POST';
  case DELETE = 'DELETE';
  case PUT = 'PUT';
  case PATCH = 'PATCH';
}

/**
 * Register things
 */
function register(Type $type, string $route, $callback): void
{
  Router::getInstance()->add($type, $route, $callback);
}

function find(Type $type, string $route): ?callable
{
  return Router::getInstance()->get($type, $route);
}