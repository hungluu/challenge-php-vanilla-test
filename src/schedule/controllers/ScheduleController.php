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
    $response->send($this->getApiResponse(ScheduleService::instance()->updateSchedules(
      $request->getParams([
        'id' => FILTER_VALIDATE_INT
      ]),
      $request->getParams([
        'name' => FILTER_SANITIZE_STRING,
        'status' => FILTER_SANITIZE_STRING,
        'start_date' => FILTER_SANITIZE_STRING,
        'end_date' => FILTER_SANITIZE_STRING
      ])
    )));
  }

  public function actionDelete (RequestInterface $request, ResponseInterface $response) {
    $response->send($this->getApiResponse(ScheduleService::instance()->deleteSchedules(
      $request->getParams([
        'id' => FILTER_VALIDATE_INT,
        'name' => FILTER_SANITIZE_STRING,
        'status' => FILTER_SANITIZE_STRING,
        'start_date' => FILTER_SANITIZE_STRING,
        'end_date' => FILTER_SANITIZE_STRING
      ])
    )));
  }
}
