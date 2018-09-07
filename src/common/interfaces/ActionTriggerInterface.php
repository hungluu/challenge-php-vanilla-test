<?php
namespace app\common\interfaces;

/**
 * Interface ActionTriggerInterface
 * @package app\common\interfaces
 */
interface ActionTriggerInterface {
  /**
   * Trigger an action
   * @param string $route route path
   * @param string $uri full uri, contains module/controller/action
   * @param RequestInterface $request request
   * @param ResponseInterface $response response
   * @return ControllerInterface
   */
  public function __invoke (string $route, string $uri, RequestInterface $request, ResponseInterface $response);
}
