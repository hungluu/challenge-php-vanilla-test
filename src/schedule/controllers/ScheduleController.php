<?php
namespace app\schedule\controllers;

use app\common\base\BaseApiController;
use app\common\interfaces\ControllerInterface;
use app\common\interfaces\RequestInterface;
use app\common\interfaces\ResponseInterface;
use app\domains\ScheduleService;

/**
 * Class ScheduleController
 * @package app\schedule\controllers
 */
class ScheduleController extends BaseApiController implements ControllerInterface {
  public function actionList (RequestInterface $request, ResponseInterface $response) {
    $response->send($this->getApiResponse(ScheduleService::instance()->getSchedules()));
  }

  public function actionCreate (RequestInterface $request, ResponseInterface $response) {
    $response->send($this->getApiResponse(ScheduleService::instance()->createSchedule($request->getParams([
      'name' => FILTER_SANITIZE_STRING,
      'status' => FILTER_SANITIZE_STRING,
      'start_date' => FILTER_SANITIZE_STRING,
      'end_date' => FILTER_SANITIZE_STRING
    ]))));
  }

  public function actionUpdate (RequestInterface $request, ResponseInterface $response) {
    $params = $request->getParams([
      'id' => FILTER_VALIDATE_INT,
      'name' => FILTER_SANITIZE_STRING,
      'status' => FILTER_SANITIZE_STRING,
      'start_date' => FILTER_SANITIZE_STRING,
      'end_date' => FILTER_SANITIZE_STRING
    ]);
    $response->send($this->getApiResponse(ScheduleService::instance()->updateSchedules(
      [
        'id' => $params['id']
      ],
      [
        'name' => $params['name'],
        'status' => $params['status'],
        'start_date' => $params['start_date'],
        'end_date' => $params['end_date']
      ]
    )));
  }

  public function actionDelete (RequestInterface $request, ResponseInterface $response) {
    $params = $request->getParams([
      'id' => FILTER_VALIDATE_INT | FILTER_SANITIZE_NUMBER_INT
    ]);
    $response->send($this->getApiResponse(ScheduleService::instance()->deleteSchedules([
      'id' => $params['id']
    ])));
  }
}
