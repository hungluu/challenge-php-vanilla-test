<?php
namespace schedule\controllers;

use app\common\components\Request;
use app\common\components\Response;
use app\schedule\controllers\IndexController;
use app\schedule\ScheduleModule;

class IndexControllerTest extends \Codeception\Test\Unit
{
  /**
   * @var \UnitRoboTester
   */
  protected $roboTester;

  public function testShouldRenderScheduleViewOnIndex () {
    $controller = new IndexController();
    $controller->setModule(new ScheduleModule());
    $this->expectOutputString(file_get_contents(__DIR__ . '/../../../../src/schedule/views/scheduleList.html'));
    $controller->actionIndex(new Request(['headers' => []]), new Response());
  }
}
