<?php
namespace app\common\components;

use app\common\base\BaseRouter;
use app\common\interfaces\RouterInterface;
use InvalidArgumentException;

/**
 * Class Router
 * @package app\common\components
 */
class Router extends BaseRouter implements RouterInterface {
  private $_routes = [];

  /**
   * Resolve a request
   *
   * @param string $uri uri
   * @param string $method request method
   * @param array $params form / request / body params
   * @param array $servers server information, example $_SERVER
   */
  public function resolve (string $uri, string $method, array $params = [], array $servers = []) {
//    foreach ($this->_routes as $route_name => $route_callback) {
//      if (strpos($uri, $route_name) === 0) {
//        $servers = filter_var_array($servers, FILTER_SANITIZE_STRING);
//        $request_options = [
//          'uri' => $uri,
//          'method' => $method,
//          'params' => $params,
//          'headers' => $servers
//        ];
//        $action_name = str_replace($route_name, '', $uri);
//        $route_callback($action_name, new Request($request_options), new Response());
//        break; // uri resolved
//      }
//    }
  }

  /**
   * Init routes
   * @param array routes with string key and callback value
   */
  public function initRoutes (array $routes) {
    foreach ($routes as $routeName => $routeCallback) {
      if (!is_string($routeName) || !is_callable($routeCallback)) {
        throw new InvalidArgumentException('routes contains invalid route format');
      }
    }

    // Save routes
    $this->_routes = $routes;
  }

  /**
   * Get routes
   * @return array init routes
   */
  public function getRoutes () {
    return $this->_routes;
  }
}
