<?php
namespace app\common\components;

use app\common\base\BaseRequest;
use app\common\interfaces\RequestInterface;

/**
 * Class Request
 * 
 * Manage requests and request headers
 * @package app\common\components
 */
class Request extends BaseRequest implements RequestInterface {
  private $_headers = [];
  private $_params = [];
  private $_method = 'GET';
  private $_uri = '';

  /**
   * Create instance of Request
   * Request constructor.
   *
   * @param array $options request options, should contain uri, method, headers ...
   */
  public function __construct (array $options) {
    $sanitized_options = filter_var_array($options, [
      'uri' => FILTER_SANITIZE_STRING,
      'method' => FILTER_SANITIZE_STRING,
      'params' => [
        "filter"=> FILTER_SANITIZE_STRING,
        "flags"=> FILTER_FORCE_ARRAY
      ],
      'headers' => [
        "filter"=> FILTER_SANITIZE_STRING,
        "flags"=> FILTER_FORCE_ARRAY
      ]
    ]);
    $this->_headers = $this->sanitizeHeaders($sanitized_options['headers']);
    $this->_params = $sanitized_options['params'];
    $this->_method = $sanitized_options['method'];
    $this->_uri = $sanitized_options['uri'];
  }

  /**
   * Get a body / form / query param
   * @param string $key param key
   * @param integer $filter default value will not sanitize returned value, used for sanitize request params
   * For more information about filter, please see http://php.net/manual/en/filter.filters.php
   * @return mixed, null on failure
   */
  public function get (string $key, int $filter = null) {
    if (isset($this->_params[$key])) {
      if (!$filter) {
        return $this->_params[$key];
      } else {
        $filtered_params = filter_var($this->_params[$key], $filter);
        return $filtered_params ? $filtered_params : null;
      }
    } else {
      return null;
    }
  }


  /**
   * Retrieve header from request
   * @param string $key key of header
   * @return string
   */
  public function getHeader (string $key) {
    return isset($this->_headers[$key])
      ? $this->_headers[$key]
      : null;
  }


  /**
   * Retrieve method of request
   * @return string
   */
  public function getMethod () {
    return $this->_method;
  }

  /**
   * Retrieve uri of request
   * @return string
   */
  public function getUri () {
    return $this->_uri;
  }
}
