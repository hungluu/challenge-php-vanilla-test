<?php
namespace app\common\base;

use app\common\base\errors\ForbiddenAccessException;
use app\common\base\errors\NotFoundException;
use app\common\interfaces\RequestInterface;
use app\common\interfaces\ResponseInterface;
use Exception;

/**
 * Class BaseApiController
 * 
 * Provide API automatically functionality and API error handling
 * @package app\common\base
 */
abstract class BaseApiController extends BaseController {
  /**
   * Check if a request is JSON API request
   * @param RequestInterface $request request
   * @return bool
   */
  public function isJsonRequest (RequestInterface $request) {
    $json_mime_types = ['application/vnd.api+json', 'application/json'];
    foreach ($json_mime_types as $mime_type) {
      if (strpos($request->getHeader('Content-Type'), $mime_type) !== false) {
        return true;
      } elseif (strpos($request->getHeader('Accept'), $mime_type) !== false) {
        return true;
      }
    }
    
    return false;
  }

  /**
   * Handle api errors
   * @param string $action_name action name
   * @param RequestInterface $request request
   * @param ResponseInterface $response response
   * @param Exception $ex exception
   * @throws Exception when current request is not JSON request, allows higher implementation to treat this error
   */
  public function handleApiError (string $action_name, RequestInterface $request, ResponseInterface $response, Exception $ex) {
    if ($this->isJsonRequest($request)) {
      if ($ex instanceof NotFoundException) {
        $response->setResponseCode(404);
        $response->send($this->getApiResponse([], $ex->getMessage(), 404), TRUE);
      } elseif ($ex instanceof ForbiddenAccessException) {
        $response->setResponseCode(403);
        $response->send($this->getApiResponse([], $ex->getMessage(), 403), TRUE);
      } else {
        $response->setResponseCode(500);
        $response->send($this->getApiResponse([], $ex->getMessage(), 500), TRUE);
      }
    } else {
      // Redirect exception to higher implementation
      throw $ex;
    }
  }

  /**
   * Get API response
   * 
   * @param array $data data
   * @param string $error_message error message, default is empty string
   * @param null $error_code error code, default is null
   * @param array $errors error objects, default is empty array
   * An error object should follow this structure ( but not strictly required )
   * {
   *   "domain": "global",
   *   "reason": "invalidParameter",
   *   "message": "Invalid string value: 'asdf'. Allowed values: [mostpopular]",
   *   "locationType": "parameter",
   *   "location": "chart"
   * }
   * 
   * @return string
   */
  public function getApiResponse (array $data, string $error_message = '', $error_code = null, array $errors = []) {
    $api_response = new \stdClass();
    $api_response->data = array_merge([], $data);
    $error = new \stdClass();
    $error->errors = $errors;
    $error->message = $error_message;
    $error->code = $error_code;
    $api_response->error = $error;
    
    return json_encode($api_response);
  }

  /**
   * Automatically handle api actions and error handling
   * @param string $action_name
   * @param RequestInterface $request
   * @param ResponseInterface $response
   * @return mixed
   * @throws Exception When error occurs
   */
  public function handleAction ($action_name, RequestInterface $request, ResponseInterface $response) {
    try {
      // JSON API
      switch ($request->getMethod()) {
        case 'GET':
          $api_action_name = $action_name . 'List';
          break;
        case 'POST':
          $api_action_name = $action_name . 'Create';
          break;
        case 'DELETE':
          $api_action_name = $action_name . 'Delete';
          break;
        case 'UPDATE':
        case 'PATCH':
          $api_action_name = $action_name . 'Update';
          break;
        default:
          $api_action_name = $action_name;
      }

      parent::handleAction($api_action_name, $request, $response);
    } catch (Exception $ex) {
      return $this->handleApiError($action_name, $request, $response, $ex);
    }
  }
}
