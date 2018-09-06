<?php
namespace app\common\interfaces;

/**
 * Interface ActionTriggerInterface
 * @package app\common\interfaces
 */
interface ActionTriggerInterface {
  /**
   * Trigger an action
   * @param string $route route path, contains module/controller/action
   * @param RequestInterface $request request
   * @param ResponseInterface $response response
   */
  public function __invoke (string $route, RequestInterface $request, ResponseInterface $response);
}
