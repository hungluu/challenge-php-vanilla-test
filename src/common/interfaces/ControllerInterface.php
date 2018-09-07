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
}
