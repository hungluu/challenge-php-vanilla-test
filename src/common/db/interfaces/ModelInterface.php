<?php
namespace app\common\db\interfaces;
use app\common\db\errors\ModelException;

/**
 * Interface ModelInterface
 * @package app\common\interfaces
 */
interface ModelInterface {
  /**
   * Set model attributes
   * @param array $attributes
   */
  public function setAttributes (array $attributes);

  /**
   * Get model attributes
   * @return array
   */
  public function getAttributes ();

  /**
   * Get an attribute
   * @param string $attribute
   * @return mixed
   */
  public function getAttribute (string $attribute);

  /**
   * Save model to database
   * @return int model id
   * @throws ModelException when save fails
   */
  public function save ();
  
  /**
   * Get database connection
   * @return ConnectionInterface
   */
  static public function getConnection ();

  /**
   * Get table name
   * @return string
   */
  static public function getTableName ();
}
