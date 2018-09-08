<?php
namespace app\common\db\interfaces;

/**
 * Class ProtectedModelInterface
 * @package app\common\db\interfaces
 */
interface ProtectedModelInterface {
  /**
   * Validate model attribute
   * @return boolean false is validation fails
   */
  public function validate ();
  
  /**
   * Filter attributes
   * @param array $attributes attributes
   * @return mixed
   */
  public function filterAttributes (array $attributes);
}
