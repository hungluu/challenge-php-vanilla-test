<?php
namespace app\common\components;

use app\common\interfaces\RequestInterface;

class RequestTest extends \Codeception\Test\Unit
{
  /**
   * @var \UnitRoboTester
   */
  protected $roboTester;

  /**
   * @var RequestInterface
   */
  protected $request;

  /**
   * @var array 
   */
  protected $valid_options = [
    'uri' => 'a/b',
    'method' => 'GET',
    'params' => [
      'valid' => '1',
      'invalid' => false,
      'int' => '2'
    ],
    'headers' => [
      'invalid' => 1,
      'HTTP_CONTENT_TYPE' => 'text/plain' 
    ],
  ];
  
  protected function _before() {
    $this->request = new Request($this->valid_options);
  }
  
  public function testCanGetUri () {
    $this->assertEquals($this->valid_options['uri'], $this->request->getUri());
  }

  public function testCanGetMethod () {
    $this->assertEquals($this->valid_options['method'], $this->request->getMethod());
  }

  public function testCanGetParam () {
    $this->assertEquals($this->valid_options['params']['valid'], $this->request->get('valid'));
  }

  public function testCanSanitizedParamWithFilters () {
    $this->assertEquals(2, $this->request->get('int', FILTER_VALIDATE_INT));
  }
  
  public function testShouldReturnNullWhenParamNotFound () {
    $this->assertEquals(null, $this->request->get('not_found'));
  }

  public function testShouldReturnNullWhenParamNotPassedWithFilter () {
    $this->assertEquals(null, $this->request->get('invalid', FILTER_VALIDATE_INT));
  }

  public function testShouldNormalizeHeaders () {
    $this->assertEquals(null, $this->request->getHeader('HTTP_CONTENT_TYPE'));
  }
  
  public function testCanGetHeader () {
    $this->assertEquals('text/plain', $this->request->getHeader('Content-Type'));
  }

  public function testShouldReturnNullWhenHeaderNotFound () {
    $this->assertEquals(null, $this->request->getHeader('not_found'));
  }

  public function testShouldNotSaveInvalidHeader () {
    $this->assertEquals(null, $this->request->getHeader('invalid'));
  }
}
