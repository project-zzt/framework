<?php

declare(strict_types=1);

namespace zzt\Core;

use Exception;
use zzt\globals\router\Type;
use zzt\Http;

/**
 * Http router
 *
 * @author Cristian Cornea <contact@corneascorner.dev>
 */
class Router
{
  private static $instance;

  /**
   * '/' => [
   *     'GET' => [
   *       'callback' => '',
   *       'module' => ''
   *     ],
   *     ...
   *   ]
   */
  private $routes = [];

  /**
   * Returns the router instance
   *
   * @return self
   */
  public static function getInstance(): self
  {
    if (self::$instance === null) {
      self::$instance = new self();
    }
    return self::$instance;
  }

  /**
   * Add an http route
   *
   * @param Type $type The http request type
   * @param string $route Name of the route
   * @param string $handler Name of the handler file with the callback function
   * @param string $module Optional module name (the framework knows how to find it on its own during bootsrap)
   * @return void
   */
  public function add(Type $type, string $route, string $handler, string $module = ''): void
  {
    $app = Application::getInstance();
    if (empty($module)) {
      $module = $app->getCurrentModule();
    }

    $config = $app->config;
    $fullPath = $config->basePath . '/' . $config->modulesFolder . '/' . $module . '/' . $handler;
    if (! $callbackPath = realpath($fullPath)) {
      throw new Exception('Path to module not found...' . $fullPath);
    }

    $this->routes[$route][$type->name] = [
      'callback' => $callbackPath,
      'module' => $module,
    ];
  }

  /**
   * Handle the request and return a response
   *
   * @param Http\Request $request The current http request
   * @return Http\Response
   */
  public function handle(Http\Request $request): Http\Response
  {
    try {
      $type = Type::tryFrom($request->method);
    } catch (\Throwable) {
      //TODO: handle
    }

    $result = $this->get($type, $request->uri, $request->params);
    if ($result->success) {
      $handler = require $result->handler;
      $response = $handler($request);
    } else {
      $response = $result->response;
    }

    return $response;
  }


  /**
   * Returns the callback path or null
   *
   * @param Type $type Http request type
   * @param string $route Name of the request route
   * @param mixed[] $params request parameters
   * @return RouterResponse
   */
  public function get(Type $type, string $route, array $params): RouterResponse
  {
    $success = true;
    $response = null;

    if (! $this->resolveType($type, $route)) {
      $success = false;
      $body = 'Method Not Allowed';
      $status = 405;
    } else if (! $this->resolveRoute($type, $route, $params)) {
      $success = false;
      $body = '404 Not Found';
      $status = 404;
    }

    if (! $success) {
      $headers = $status != 404 ? $this->getAllowHeaders($this->routes[$route]) : [];
      $response = Http\Response::new($body, $headers, $status);
    }

    return RouterResponse::new(
      $success,
      $this->routes[$route][$type->name]['callback'],
      $this->routes[$route][$type->name]['module'],
      $response,
    );
  }

  private function getAllowHeaders(array $route): array 
  {
    $types = array_keys($route);
    return ['Allowed' => implode(',', $types)];
  }

  private function resolveType(Type $type, string $route): bool
  {
    return true;
  }

  private function resolveRoute(Type $type, string $route, array $params): bool
  {
    return true;
  }
}

class RouterResponse
{
  private function __construct(
    public readonly bool $success,
    public readonly ?string $handler,
    public readonly ?string $module,
    public readonly ?Http\Response $response,
  ) {}

  public static function new(bool $success, ?string $handler, ?string $module, ?Http\Response $response = null): self
  {
    if ($success && ($handler === null || $module === null)) {
      throw new Exception('Handler not set on router success');
    }
    if (!$success && $response === null) {
      throw new Exception('Response not set on router fail');
    }

    return new self($success, $handler, $module, $response);
  }
}
