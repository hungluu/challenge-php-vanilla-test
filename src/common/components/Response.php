<?php
namespace app\common\components;

use app\common\base\BaseResponse;
use app\common\interfaces\ComponentInterface;
use app\common\interfaces\ResponseInterface;
use Exception;

/**
 * Class Response
 * @package app\common\components
 */
class Response extends BaseResponse implements ResponseInterface, ComponentInterface {
  /**
   * Response headers
   * @var array 
   */
  protected $_headers = [];

  /**
   * Response code header
   * @var string
   */
  protected $_response_code = '';

  /**
   * Whether headers sent
   * @var bool 
   */
  protected $_headers_sent = false;

  /**
   * Create a response
   * @param array $options
   */
  public function __construct (array $options = []) {
    parent::__construct($options);
    $this->setResponseCode(200);
  }

  /**
   * Send response to client
   * @param string $text text to be sent
   * @param boolean $send_header whether to send headers
   * @throws Exception when error occurs
   */
  public function send (string $text, bool $send_header = FALSE) {
    if ($send_header) {
      $this->sendHeaders();
    }
    
    echo $text;
  }

  /**
   * Set response code
   * @param integer $code
   */
  public function setResponseCode (int $code) {
    switch ($code) {
      case 100: $text = 'Continue'; break;
      case 101: $text = 'Switching Protocols'; break;
      case 200: $text = 'OK'; break;
      case 201: $text = 'Created'; break;
      case 202: $text = 'Accepted'; break;
      case 203: $text = 'Non-Authoritative Information'; break;
      case 204: $text = 'No Content'; break;
      case 205: $text = 'Reset Content'; break;
      case 206: $text = 'Partial Content'; break;
      case 300: $text = 'Multiple Choices'; break;
      case 301: $text = 'Moved Permanently'; break;
      case 302: $text = 'Moved Temporarily'; break;
      case 303: $text = 'See Other'; break;
      case 304: $text = 'Not Modified'; break;
      case 305: $text = 'Use Proxy'; break;
      case 400: $text = 'Bad Request'; break;
      case 401: $text = 'Unauthorized'; break;
      case 402: $text = 'Payment Required'; break;
      case 403: $text = 'Forbidden'; break;
      case 404: $text = 'Not Found'; break;
      case 405: $text = 'Method Not Allowed'; break;
      case 406: $text = 'Not Acceptable'; break;
      case 407: $text = 'Proxy Authentication Required'; break;
      case 408: $text = 'Request Time-out'; break;
      case 409: $text = 'Conflict'; break;
      case 410: $text = 'Gone'; break;
      case 411: $text = 'Length Required'; break;
      case 412: $text = 'Precondition Failed'; break;
      case 413: $text = 'Request Entity Too Large'; break;
      case 414: $text = 'Request-URI Too Large'; break;
      case 415: $text = 'Unsupported Media Type'; break;
      case 500: $text = 'Internal Server Error'; break;
      case 501: $text = 'Not Implemented'; break;
      case 502: $text = 'Bad Gateway'; break;
      case 503: $text = 'Service Unavailable'; break;
      case 504: $text = 'Gateway Time-out'; break;
      case 505: $text = 'HTTP Version not supported'; break;
      default: $text = 'Unknown response code';
    }

    $server_protocol = filter_input(INPUT_SERVER, 'SERVER_PROTOCOL', FILTER_SANITIZE_STRING);
    $protocol = $server_protocol ? $server_protocol : 'HTTP/1.0';
    $this->_response_code = $protocol . ' ' . $code . ' ' . $text;
  }

  /**
   * Get current set response code
   * @return string
   */
  public function getResponseCode () {
    return $this->_response_code;
  }

  /**
   * Send headers
   * @throws Exception When headers sent
   */
  public function sendHeaders () {
    if ($this->checkHeadersSent()) {
      throw new Exception('Headers already sent');  
    }
    
    header($this->getResponseCode());
    foreach ($this->_headers as $header) {
      header($header);
    }
    $this->_headers_sent = true;
  }

  /**
   * Whether if headers sent
   * @return bool
   */
  public function checkHeadersSent () {
    return $this->_headers_sent;
  }

  /**
   * Set response header
   * @param string $key key of header
   * @param string $value value of header
   */
  public function setHeader (string $key, string $value) {
    $this->_headers[$key] = $key . ' : ' . $value;
  }

  /**
   * Get all set response headers
   * @return array
   */
  public function getHeaders () {
    return $this->_headers;
  }
}
