<?php
namespace app\common\base;

require_once __DIR__ . '/BaseModuleTest/BaseModuleChild.php';
require_once __DIR__ . '/BaseModuleTest/controllers/IndexController.php';
require_once __DIR__ . '/BaseModuleTest/controllers/OtherController.php';

use app\common\base\BaseModuleTest\BaseModuleChild;
use app\common\components\Request;
use app\common\components\Response;
use app\common\interfaces\ModuleInterface;
use app\common\base\BaseModuleTest\controllers\IndexController;
use Exception;

class BaseModuleTest extends \Codeception\Test\Unit
{
  /**
   * @var \UnitRoboTester
   */
  protected $roboTester;

  /**
   * @var ModuleInterface
   */
  protected $module;
  
  protected function _before () {
    $this->module = new BaseModuleChild();
  }
  
  protected function getDir () {
    return str_replace('\\', '/', __DIR__);
  }

  public function testCanGetPath () {
    $this->assertEquals($this->getDir() . '/BaseModuleTest', $this->module->getPath());
  }

  public function testCanGetSubPath () {
    $this->assertEquals($this->getDir() . '/BaseModuleTest/sub-path', $this->module->getPath('sub-path'));
  }

  public function testCanResolveController () {
    $this->assertEquals([
      'path' => $this->getDir() . '/BaseModuleTest/controllers/TestController.php',
      'className' => 'app\common\base\BaseModuleTest\controllers\TestController'
    ], $this->module->resolveController('test'));

    $this->assertEquals([
      'path' => $this->getDir() . '/BaseModuleTest/controllers/test/MoreController.php',
      'className' => 'app\common\base\BaseModuleTest\controllers\test\MoreController'
    ], $this->module->resolveController('test/more'));
  }

  public function testCanResolveView () {
    $this->assertEquals([
      'path' => $this->getDir() . '/BaseModuleTest/views/test'
    ], $this->module->resolveView('test'));

    $this->assertEquals([
      'path' => $this->getDir() . '/BaseModuleTest/views/test/more.html'
    ], $this->module->resolveView('test/more.html'));
  }
  
  public function testCanRunAction () {
    $this->assertInstanceOf(IndexController::class, $this->module->__invoke('TEST_ACTION', 'TEST_ACTION/test', new Request(['headers' => []]), new Response()));
  }

  public function testShouldRunActionIndexIfNoActionSpecified () {
    $this->assertInstanceOf(IndexController::class, $this->module->__invoke('TEST_ACTION', 'TEST_ACTION', new Request(['headers' => []]), new Response()));
  }

  public function testShouldThrowExceptionWhenControllerNotFound () {
    $this->expectException(Exception::class);
    $this->module->__invoke('TEST_ACTION_FILE_NOT_FOUND', 'TEST_ACTION_FILE_NOT_FOUND/TEST_ACTION_FILE_NOT_FOUND/test',  new Request(['headers' => []]), new Response());
  }

  public function testShouldThrowExceptionWhenControllerClassNotFound () {
    $this->expectException(Exception::class);
    $this->module->__invoke('TEST_ACTION_CLASS_NOT_FOUND', 'TEST_ACTION_CLASS_NOT_FOUND/TEST_ACTION_CLASS_NOT_FOUND/test', new Request(['headers' => []]), new Response());
  }

  public function testShouldThrowExceptionWhenActionNotFound () {
    $this->expectException(Exception::class);
    $this->module->__invoke('TEST_ACTION', 'TEST_ACTION/other/testNotFound', new Request(['headers' => []]), new Response());
  }

  public function testShouldInjectModuleIntoCreatedController () {
    $controller = $this->module->__invoke('TEST_ACTION', 'TEST_ACTION/test', new Request(['headers' => []]), new Response());
    $this->assertEquals($this->module, $controller->getModule());
  }
}
