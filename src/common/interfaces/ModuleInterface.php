<?php
namespace app\common\interfaces;

use Exception;

/**
 * Interface ModuleInterface
 * @package app\common\interfaces
 */
interface ModuleInterface {
  /**
   * Get module path
   *
   * @param string $sub_path sub path
   * @return string
   */
  public function getPath (string $sub_path = null);

  /**
   * Resolve controller by path
   * @param string $controller_path controller path
   * @return array
   */
  public function resolveController (string $controller_path);

  /**
   * @param string $view_path view path
   * @return array resolved view
   */
  public function resolveView (string $view_path);
}
