<?php
namespace app\common\interfaces;

/**
 * Interface ControllerInterface
 * @package app\common\interfaces
 */
interface ControllerInterface {
  /**
   * Set module
   * @param ModuleInterface $module
   */
  public function setModule (ModuleInterface $module);

  /**
   * Get module
   * @return ModuleInterface
   */
  public function getModule ();

  /**
   * Handle action
   * @param string $action_name name of action
   * @param RequestInterface $request request
   * @param ResponseInterface $response response
   * @return mixed
   */
  public function handleAction ($action_name, RequestInterface $request, ResponseInterface $response);
}
