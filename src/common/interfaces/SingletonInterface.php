<?php
namespace app\common\interfaces;

/**
 * Interface SingletonInterface
 * @package app\common\interfaces
 */
interface SingletonInterface {
  /**
   * Return current singleton instance
   * @return static
   */
  public static function instance();
}
