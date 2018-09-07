<?php
namespace app\common\components;

use app\common\interfaces\RouterInterface;
use InvalidArgumentException;

class RouterTest extends \Codeception\Test\Unit
{
  /**
   * @var \UnitRoboTester
   */
  protected $roboTester;

  /**
   * @var RouterInterface
   */
  protected $router;
    
  protected function _before() {
    $this->router = new Router();
  }

  public function testCanGetDefaultRoutes() {
    $this->assertEquals([], $this->router->getRoutes());
  }
  
  public function testCanInitRoutes() {
    $routes = ['a' => 'strtolower'];
    $this->router->initRoutes($routes);
    $this->assertEquals($routes, $this->router->getRoutes());
  }
  
  public function testShouldThrowExceptionWhenARouteNameIsNotString () {
    $routes = [1 => 'strtolower'];
    $this->expectException(InvalidArgumentException::class);
    $this->router->initRoutes($routes);
  }

  public function testShouldThrowExceptionWhenARouteCallbackIsNotCallable () {
    $routes = ['a' => 'undefined-function'];
    $this->expectException(InvalidArgumentException::class);
    $this->router->initRoutes($routes);
  }
  
  public function testCanResolveRoutes () {
    $test_callback = function () {
      return 'tested';
    };
    
    $this->router->initRoutes(['a' => $test_callback]);
    $this->assertEquals($test_callback(), $this->router->resolve('a'));
  }

  public function testShouldReturnNullWhenNoRouteMatched () {
    $this->assertEquals(null, $this->router->resolve('not-found'));
  }
}
