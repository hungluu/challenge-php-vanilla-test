<?php
namespace app\schedule\controllers;

use app\common\base\BaseController;
use app\common\interfaces\ControllerInterface;
use app\common\interfaces\RequestInterface;
use app\common\interfaces\ResponseInterface;
use Exception;

/**
 * Class IndexController
 * @package app\schedule\controllers
 */
class IndexController extends BaseController implements ControllerInterface {
  /**
   * @param RequestInterface $request
   * @param ResponseInterface $response
   * @throws Exception When error occurs during View creation
   */
  public function actionIndex (RequestInterface $request, ResponseInterface $response) {
    $response->send($this->getView('scheduleList.html')->getContents());
  }
}
