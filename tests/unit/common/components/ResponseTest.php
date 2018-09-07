<?php
namespace app\common\components;

use Exception;

class ResponseTest extends \Codeception\Test\Unit
{
  /**
   * @var \UnitRoboTester
   */
  protected $roboTester;

  /**
   * @var Response
   */
  protected $response;
  
  protected function _before () {
    $this->response = new Response();
  }
  
  public function testCanSetHeader () {
    $this->response->setHeader('A', 1);
    $this->assertContains('A : 1', $this->response->getHeaders());
  }
  
  public function testCanRenderText () {
    $this->expectOutputString('tested');
    $this->response->send('tested');
  }

  public function testShouldInitializeResponseCode () {
    $this->assertEquals('HTTP/1.0 200 OK', $this->response->getResponseCode());
  }
  
  public function testCanSetResponseCode () {
    $this->response->setResponseCode(401);
    $this->assertEquals('HTTP/1.0 401 Unauthorized', $this->response->getResponseCode());
  }
  
  public function testCanSendHeaders () {
    $this->response->setHeader('A', 1);
    $this->response->sendHeaders();
    $this->assertEquals(true, $this->response->checkHeadersSent());
  }

  public function testShouldNotResentHeaders () {
    $this->expectException(Exception::class);
    $this->response->setHeader('A', 1);
    $this->response->sendHeaders();
    $this->response->sendHeaders();
  }

  public function testCanCheckIfHeadersSent () {
    $this->response->setHeader('A', 1);
    $this->assertEquals(false, $this->response->checkHeadersSent());
  }
  
  public function testCanSendHeadersAlongWithBody () {
    $this->response->setHeader('A', 1);
    $this->response->send('', TRUE);
    $this->assertEquals(true, $this->response->checkHeadersSent());
  }
}
