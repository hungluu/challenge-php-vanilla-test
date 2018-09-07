<?php
namespace app\schedule;

class ScheduleModuleTest extends \Codeception\Test\Unit
{
  /**
   * @var \UnitRoboTester
   */
  protected $roboTester;
  
  public function testCanGetPath () {
    $module = new ScheduleModule();
    $this->assertEquals(realpath(__DIR__ . '/../../../src/schedule/'), realpath($module->getPath()));
  }

  public function testCanGetSubPath () {
    $module = new ScheduleModule();
    $this->assertEquals($module->getPath() . '/a', $module->getPath('a'));
  }
}
