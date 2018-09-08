<?php
namespace app\common\components;

use app\common\interfaces\ViewInterface;
use Exception;

class ViewTest extends \Codeception\Test\Unit
{
  /**
   * @var \UnitRoboTester
   */
  protected $roboTester;

  public function testShouldThrowExceptionIfViewPathNotProvided () {
    $this->expectException(Exception::class);
    $view = new View();
  }
  
  public function testShouldThrowExceptionIfViewPathNotFound () {
    $this->expectException(Exception::class);
    $view = new View([
      'path' => 'not-found'
    ]);
  }
  
  public function testCanGetViewPath () {
    $view = new View([
      'path' => __DIR__ . '/ViewTest.html'
    ]);
    $this->assertEquals(__DIR__ . '/ViewTest.html', $view->getViewPath());
  }
  
  public function testCanGetContents () {
    $view = new View([
      'path' => __DIR__ . '/ViewTest.html'
    ]);
    $this->assertEquals('view tested', $view->getContents());
  }
}
