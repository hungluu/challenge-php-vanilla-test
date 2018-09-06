<?php
namespace app\common\base;

/**
 * Class BaseRequest
 * @package app\common\base
 */
class BaseRequest extends BaseComponent {

  /**
   * Sanitize received headers
   * @param array $raw_headers headers
   * @return array
   */
  public function sanitizeHeaders (array $raw_headers) {
    $headers = [];
    foreach ($raw_headers as $raw_key => $raw_value) {
      // header detected
      if (strpos($raw_key, 'HTTP_') === 0) {
        $header_key = str_replace('HTTP_', '', $raw_key);
        // normalize header, example CONTENT_TYPE to Content-Type
        $normalized_key = str_replace(' ', '-', ucwords(str_replace('_', ' ', strtolower($header_key))));
        $headers[$normalized_key] = $raw_value;
      }
    }
    
    return $headers;
  }
}
