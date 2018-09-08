<?php
namespace app\db\interfaces;

/**
 * Interface ModelInterface
 * @package app\common\interfaces
 */
interface ModelInterface {
  /**
   * Get database connection
   * @return ConnectionInterface
   */
  public function getConnection ();

  /**
   * Get table name
   * @return string
   */
  public static function getTableName ();
}
