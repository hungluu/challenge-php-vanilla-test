<?php
namespace app\common\components;

use app\common\interfaces\ResponseInterface;

class ResponseTest extends \Codeception\Test\Unit
{
  /**
   * @var \UnitRoboTester
   */
  protected $roboTester;

  /**
   * @var ResponseInterface
   */
  protected $response;
  
  protected function _before () {
    $this->response = new Response();
  }
  
  public function testCanSetHeader () {
    $this->response->setHeader('A', 1);
  }
  
  public function testCanRenderText () {
    $this->expectOutputString('tested');
    $this->response->send('tested');
  }
}
