<?php
namespace app\common;

use Exception;
use app\common\base\BaseComponent;
use app\common\interfaces\ComponentInterface;

class TestComponent extends BaseComponent implements ComponentInterface {}

class AppTest extends \Codeception\Test\Unit
{
  /**
   * @var \UnitRoboTester
   */
  protected $roboTester;
  
  protected $component;
  
  public function __construct (?string $name = null, array $data = [], string $dataName = '') {
    parent::__construct($name, $data, $dataName);
    $this->component = new TestComponent();
  }

  public function testShouldBeSingleton () {
    $this->assertEquals(App::instance(), App::instance());
  }
  
  public function testCanAddComponent () {
    try {
      App::instance()->addComponent('test', $this->component);
    } catch (Exception $ex) {
      $this->fail('App can not add component');
    }
  }
  
  public function testCanGetComponent () {
    $this->assertEquals($this->component, App::instance()->getComponent('test'));
  }

  public function testShouldThrowExceptionWhenComponentNotFound () {
    $this->expectException(Exception::class);
    App::instance()->getComponent('not-found');
  }

  public function testCanGetComponentWithGetter () {
    $this->assertEquals($this->component, App::instance()->test);
  }

  public function testShouldThrowExceptionWhenComponentNotFoundWithGetter () {
    $this->expectException(Exception::class);
    App::instance()->notFound;
  }

  public function testShouldBeRunnable () {
    try {
      App::instance()->run(__DIR__);
    } catch (Exception $ex) {
      $this->fail('App is not runnable');
    }
  }

  public function testShouldThrowExceptionWhenRootDirNotFound () {
    $this->expectException(Exception::class);
    App::instance()->run(__DIR__ . '/not-found');
  }
}
