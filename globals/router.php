<?php

declare(strict_types=1);

namespace zzt\globals\router;

use zzt\Core\Router;
use zzt\Http\Request;

/**
 * Request types
 */
enum Type: string
{
  case GET = 'GET';
  case POST = 'POST';
  case DELETE = 'DELETE';
  case PUT = 'PUT';
  case PATCH = 'PATCH';
}

/**
* Register new route.
*
* @param Type $type Request Type
* @param string $route Route identifier
* @param string $callback Callback to route handler
* @return void
*/
function register(Type $type, string $route, string $callback): void
{
  Router::getInstance()->add($type, $route, $callback);
}

/**
* Find request route.
*
* @param Request $request Current request
* @return callable|null
*/
function find(Request $request): ?string
{
  try {
    $type = Type::tryFrom($request->method);
  } catch (\Throwable) {
    //TODO: handle
  }

  return Router::getInstance()->get($type, $request->uri);
}
