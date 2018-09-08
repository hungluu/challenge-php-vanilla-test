<?php
namespace app\common\interfaces;

/**
 * Interface RouterInterface
 * @package app\common\interfaces
 */
interface RouterInterface {
  /**
   * Resolve a request
   * 
   * @param string $uri uri
   * @param string $method request method
   * @param array $params form / request / body params
   * @param array $servers server information, example $_SERVER
   */
  public function resolve (string $uri, string $method = 'GET', array $params = [], array $servers = []);
  
  /**
   * Init routes
   * @param array routes with string key and callback value
   */
  public function initRoutes (array $routes);
}
