<?php
namespace app\common\base\BaseApiControllerTest;

use app\common\base\BaseApiController;
use app\common\interfaces\ControllerInterface;
use app\common\interfaces\RequestInterface;
use app\common\interfaces\ResponseInterface;

class BaseControllerChild extends BaseApiController implements ControllerInterface {
  public function actionTestCreate (RequestInterface $request, ResponseInterface $response) {
    $response->send('tested-create');
  }

  public function actionTestList (RequestInterface $request, ResponseInterface $response) {
    $response->send('tested-list');
  }

  public function actionTestUpdate (RequestInterface $request, ResponseInterface $response) {
    $response->send('tested-update');
  }

  public function actionTestDelete (RequestInterface $request, ResponseInterface $response) {
    $response->send('tested-delete');
  }

  public function actionCreate (RequestInterface $request, ResponseInterface $response) {
    $response->send('tested-index-create');
  }

  public function actionList (RequestInterface $request, ResponseInterface $response) {
    $response->send('tested-index-list');
  }

  public function actionUpdate (RequestInterface $request, ResponseInterface $response) {
    $response->send('tested-index-update');
  }

  public function actionDelete (RequestInterface $request, ResponseInterface $response) {
    $response->send('tested-index-delete');
  }
  
  public function actionNormalList (RequestInterface $request, ResponseInterface $response) {
    $response->send('normal');
  }
  
  public function actionFailList () {
    throw new \Exception('failed');
  }
}
