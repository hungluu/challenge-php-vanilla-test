<?php
namespace app\common\interfaces;

/**
 * Interface ResponseInterface
 * @package app\common\interfaces
 */
interface ResponseInterface {
  /**
   * Set response header
   * @param string $key key of header
   * @param string $value value of header
   */
  public function setHeader (string $key, string $value);

  /**
   * Send response to client
   * @param string $text text to be sent
   */
  public function send (string $text);
}
