<?php
namespace app\common\components;

use app\common\base\BaseResponse;
use app\common\interfaces\ResponseInterface;

/**
 * Class Response
 * @package app\common\components
 */
class Response extends BaseResponse implements ResponseInterface {
  /**
   * Send response to client
   * @param string $text text to be sent
   */
  public function send (string $text) {
    ob_flush();
    echo $text;
  }

  /**
   * Set response header
   * @param string $key key of header
   * @param string $value value of header
   */
  public function setHeader (string $key, string $value) {
    header($key . ':' . $value);
  }
}
