<?php

declare(strict_types=1);

namespace zzt\globals\router;

use zzt\Core\Router;
use zzt\Http\Request;

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
function register(Type $type, string $route, callable $callback): void
{
  Router::getInstance()->add($type, $route, $callback);
}

function find(Request $request): ?callable
{
  try {
    $type = Type::tryFrom($request->method);
  } catch (\Throwable) {
    //TODO: handle
  }

  return Router::getInstance()->get($type, $request->uri);
}
