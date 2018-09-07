<?php
namespace app\common\base;

require_once __DIR__ . '/BaseApiControllerTest/BaseControllerChild.php';
require_once __DIR__ . '/../../../../src/common/errors/ForbiddenAccessException.php';
require_once __DIR__ . '/../../../../src/common/errors/NotFoundException.php';

use app\common\base\BaseApiControllerTest\BaseControllerChild;
use app\common\base\errors\NotFoundException;
use app\common\base\errors\ForbiddenAccessException;
use app\common\components\Request;
use app\common\components\Response;
use app\common\interfaces\RequestInterface;
use Exception;

class BaseApiControllerTest extends \Codeception\Test\Unit
{
  /**
   * @var \UnitRoboTester
   */
  protected $roboTester;

  /**
   * @var BaseControllerChild
   */
  protected $controller;

  protected function _before () {
    $this->controller = new BaseControllerChild();
  }
  
  protected function createJsonRequest ($headers = [], $options = []) {
    return new Request(array_merge([
      'headers' => array_merge(['HTTP_ACCEPT' => 'application/vnd.api+json'], $headers)
    ], $options));
  }
  
  public function testCanCheckRequestIsJsonRequest () {
    $json_headers1 = [
      'HTTP_CONTENT_TYPE' => 'application/json'
    ];
    $json_headers2 = [
      'HTTP_ACCEPT' => 'application/json'
    ];
    $this->assertEquals(true, $this->controller->isJsonRequest(new Request(['headers' => $json_headers1])));
    $this->assertEquals(true, $this->controller->isJsonRequest(new Request(['headers' => $json_headers2])));
    $this->assertEquals(false, $this->controller->isJsonRequest(new Request(['headers' => []])));
  }
  
  public function testCanGetApiResponse () {
    $data = ['test' => 1];
    $api_reponse1 = [
      'data' => $data,
      'error' => [
        'message' => '',
        'errors' => [],
        'code' => null
      ]
    ];

    $api_reponse2 = [
      'data' => [],
      'error' => [
        'message' => 'message',
        'errors' => [],
        'code' => 500
      ]
    ];
    
    $this->assertEquals($api_reponse2, json_decode($this->controller->getApiResponse([], 'message', 500), true));
    $this->assertEquals($api_reponse1, json_decode($this->controller->getApiResponse($data), true));
  }

  public function testShouldLetHigherImplementationTreatErrorIfNotAJsonRequest () {
    $this->expectException(Exception::class);
    $this->controller->handleApiError('', new Request(['headers' => []]), new Response(), new Exception(''));
  }

  public function testCanHandleNotFoundError () {
    $this->expectOutputString($this->controller->getApiResponse([], 'not-found', 404));
    $this->controller->handleApiError('test', $this->createJsonRequest(), new Response(), new NotFoundException('not-found'));
  }

  public function testCanHandleForbiddenError () {
    $this->expectOutputString($this->controller->getApiResponse([], 'forbidden', 403));
    $this->controller->handleApiError('', $this->createJsonRequest(), new Response(), new ForbiddenAccessException('forbidden'));
  }

  public function testCanHandleOtherTypesOfError () {
    $this->expectOutputString($this->controller->getApiResponse([], 'other', 500));
    $this->controller->handleApiError('', $this->createJsonRequest(), new Response(), new Exception('other'));
  }

  public function testCanhandleAction () {
    $this->expectOutputString('normal');
    $this->controller->handleAction('normal', new Request(['headers' => []]), new Response());
  }

  public function testShouldHandleErrorWhenActionFailed () {
    $this->expectOutputString($this->controller->getApiResponse([], 'failed', 500));
    $this->controller->handleAction('fail', $this->createJsonRequest(), new Response());
  }

  public function testCanHandleGetAction () {
    $this->expectOutputString('tested-list');
    $this->controller->handleAction('test', $this->createJsonRequest(), new Response());
  }

  public function testCanHandlePostAction () {
    $this->expectOutputString('tested-create');
    $this->controller->handleAction('test', $this->createJsonRequest([], ['method' => 'POST']), new Response());
  }

  public function testCanHandleUpdateAction () {
    $this->expectOutputString('tested-updatetested-update');
    $this->controller->handleAction('test', $this->createJsonRequest([], ['method' => 'PATCH']), new Response());
    $this->controller->handleAction('test', $this->createJsonRequest([], ['method' => 'UPDATE']), new Response());
  }

  public function testCanHandleDeleteAction () {
    $this->expectOutputString('tested-index-delete');
    $this->controller->handleAction('', $this->createJsonRequest([], ['method' => 'DELETE']), new Response());
  }

  public function testCanHandleIndexGetAction () {
    $this->expectOutputString('tested-index-list');
    $this->controller->handleAction('', $this->createJsonRequest(), new Response());
  }

  public function testCanHandleIndexPostAction () {
    $this->expectOutputString('tested-index-create');
    $this->controller->handleAction('', $this->createJsonRequest([], ['method' => 'POST']), new Response());
  }

  public function testCanHandleIndexUpdateAction () {
    $this->expectOutputString('tested-index-updatetested-index-update');
    $this->controller->handleAction('', $this->createJsonRequest([], ['method' => 'PATCH']), new Response());
    $this->controller->handleAction('', $this->createJsonRequest([], ['method' => 'UPDATE']), new Response());
  }

  public function testCanHandleIndexDeleteAction () {
    $this->expectOutputString('tested-index-delete');
    $this->controller->handleAction('', $this->createJsonRequest([], ['method' => 'DELETE']), new Response());
  }
}
