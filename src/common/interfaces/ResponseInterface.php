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
   * Send headers
   */
  public function sendHeaders ();

  /**
   * Get headers
   */
  public function getHeaders ();
  
  /**
   * Send response to client
   * @param string $text text to be sent
   * @param boolean $send_header whether to send headers
   */
  public function send (string $text, bool $send_header = FALSE);
}
