<?php
namespace app\common\base;
require_once __DIR__ . '/BaseControllerTest/BaseControllerChild.php';
require_once __DIR__ . '/BaseControllerTest/BaseModuleChild.php';

use app\common\components\Request;
use app\common\components\Response;
use app\common\interfaces\ControllerInterface;
use app\common\base\BaseControllerTest\BaseModuleChild;
use app\common\base\BaseControllerTest\BaseControllerChild;
use Exception;

class BaseControllerTest extends \Codeception\Test\Unit
{
  /**
   * @var \UnitRoboTester
   */
  protected $roboTester;

  /**
   * @var ControllerInterface
   */
  protected $controller;

  protected function _before () {
    $this->controller = new BaseControllerChild();
  }

  public function testCanSetModule () {
    $module = new BaseModuleChild();
    $this->controller->setModule($module);
    $this->assertInstanceOf(BaseModuleChild::class, $module);
  }

  public function testCanGetModule () {
    $module = new BaseModuleChild();
    $this->controller->setModule($module);
    $this->assertEquals($module, $this->controller->getModule());
  }

  public function testCanGetView () {
    $module = new BaseModuleChild();
    $this->controller->setModule($module);
    $this->assertEquals($module, $this->controller->getModule());
  }
  
  public function testCanHandleAction () {
    $this->assertEquals('tested-action', $this->controller->handleAction('test', new Request(['headers' => []]), new Response()));
  }
  
  public function testShouldThrowExceptionWhenActionNotFound () {
    $this->expectException(Exception::class);
    $this->controller->handleAction('not-found', new Request(['headers' => []]), new Response());
  }
}
