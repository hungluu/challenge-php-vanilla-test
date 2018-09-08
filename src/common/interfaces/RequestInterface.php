<?php
namespace app\common\interfaces;

/**
 * Interface RequestInterface
 * @package app\common\interfaces
 */
interface RequestInterface {
  /**
   * Retrieve header from request
   * @param string $key key of header
   * @return string
   */
  public function getHeader (string $key);

  /**
   * Retrieve uri of request
   * @return string
   */
  public function getUri ();

  /**
   * Retrieve method of request
   * @return string
   */
  public function getMethod ();

  /**
   * Get a body / form / query param
   * @param string $key param key
   * @param integer $filter default value will not sanitize returned value, used for sanitize request params
   * For more information about filter, please see http://php.net/manual/en/filter.filters.php
   * @return mixed
   */
  public function get (string $key, int $filter = FILTER_FLAG_NONE);

  /**
   * Get all params
   * @param integer|array $filter default value will not sanitize returned value, used for sanitize request params
   * @return array
   */
  public function getParams ($filter = null);
}
