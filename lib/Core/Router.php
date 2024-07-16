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
  private const REGEX_VALID_SEGMENTS = "/\/[a-zA-Z0-9-_:\/]+/";
  private const REGEX_VALID_PARAM = "/:[a-zA-Z0-9-_]+/";
  private const REGEX_ROUTE_PARAM = "[a-zA-Z0-9-_]+";

  private static $instance;

  /**
   * Example:
   * '/' => [
   *     'GET' => [
   *       'callback' => '',
   *       'module' => '',
   *       'params' => [],
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
    $fullPath = "{$config->basePath}/{$config->modulesFolder}/{$module}/{$handler}";
    if (!$callbackPath = realpath($fullPath)) {
      throw new Exception("Path to module not found... {$fullPath}");
    }

    $route = $this->parse($route);

    $this->routes[$route][$type->name] = [
      'callback' => $callbackPath,
      'module' => $module,
      'params' => [],
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

    if (!$resolvedType = $this->resolveType($type, $route)) {
      $success = false;
      $body = 'Method Not Allowed';
      $status = 405;
    } else if (!$resolvedRoute = $this->resolve($route)) {
      $success = false;
      $body = '404 Not Found';
      $status = 404;
    }

    if (!$success) {
      $headers = $status != 404 ? $this->getAllowHeaders($this->routes[$route]) : [];
      $response = Http\Response::new($body, $headers, $status);
    }

    return RouterResponse::new(
      $success,
      $this->routes[$resolvedRoute][$resolvedType]['callback'],
      $this->routes[$resolvedRoute][$resolvedType]['module'],
      $this->routes[$resolvedRoute][$resolvedType]['params'],
      $response,
    );
  }

  private function resolve(string $route): ?string
  {
    foreach ($this->routes as $delimiter => $content) {
      if (preg_match($delimiter, $route)) {
        return $delimiter;
      }
    }

    return null;
  }

  private function parse(string $route): ?string
  {
    $route = rawurldecode($route);

    // Validate route
    if (!preg_match(self::REGEX_VALID_SEGMENTS, $route)) {
      // Throw exception
    }

    $segments = explode('/', $route);
    if (empty($segments)) {
      //TODO Throw exception
    }

    $total = count($segments);
    if ($total == 2 && $segments[1] === '') {
      $segments = [];
    } else {
      unset($segments[0]);
    }

    $final = '\/';
    foreach ($segments as $segment) {
      //TODO Only allow a-z0-9 and _ and -
      if (preg_match(self::REGEX_VALID_PARAM, $segment)) {
        $segment = self::REGEX_ROUTE_PARAM;
      }
      $final .= "{$segment}\/";
    }
    $final = rtrim($final, '\/');
    $final = "/^{$final}$/";

    return $final;
  }
  private function getAllowHeaders(array $route): array
  {
    $types = array_keys($route);
    return ['Allowed' => implode(',', $types)];
  }

  private function resolveType(Type $type, string $route): ?string
  {
    return 'GET';
  }
}

/**
 * Returned response of a dispatched route.
 */
final class RouterResponse
{
  private function __construct(
    public readonly bool $success,
    public readonly ?string $handler,
    public readonly ?string $module,
    public readonly ?array $params,
    public readonly ?Http\Response $response,
  ) {
  }

  public static function new(
    bool $success,
    ?string $handler,
    ?string $module,
    ?array $params,
    ?Http\Response $response = null
  ): self {
    if ($success && ($handler === null || $module === null)) {
      throw new Exception('Handler not set on route success');
    }
    if (!$success && $response === null) {
      throw new Exception('Response not set on route fail');
    }

    return new self($success, $handler, $module, $params, $response);
  }
}