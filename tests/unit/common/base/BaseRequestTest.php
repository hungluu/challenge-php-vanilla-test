<?php
namespace app\common\base;

class BaseRequest1 extends BaseRequest {}

class BaseRequestTest extends \Codeception\Test\Unit
{
  protected $router;
  /**
   * @var \UnitRoboTester
   */
  protected $roboTester;
    
  public function testCanSanitizeHeaders () {
    $request = new BaseRequest1();
    $this->assertEquals(['Content-Type' => 'text/html'], $request->sanitizeHeaders(['HTTP_CONTENT_TYPE' => 'text/html']));
  }

  public function testRetrieveHeadersFromGlobalServer () {
    $request = new BaseRequest1();
    $this->assertEquals(['Content-Type' => 'text/html'], $request->sanitizeHeaders(['HTTP_CONTENT_TYPE' => 'text/html']));
    $this->assertEquals([], $request->sanitizeHeaders(['CONTENT_TYPE' => 'text/html']));
  }
}
