<?php
namespace app\common\interfaces;

/**
 * Interface ViewInterface
 * @package app\common\interfaces
 */
interface ViewInterface {
  /**
   * Get view path
   * @return string
   */
  public function getViewPath ();

  /**
   * Get view contents
   * @param array $options options
   * @return string
   */
  public function getContents (array $options = []);
}
