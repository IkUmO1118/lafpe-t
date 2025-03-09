<?php

namespace Tests\Integration;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Response\HTTPRenderer;

class RoutingTest extends TestCase
{
  private array $validDiagnosisData;

  protected function setUp(): void
  {
    parent::setUp();

    $this->validDiagnosisData = [
      'Q1' => [0],
      'Q2' => [0, 1],
      'Q3' => [
        'openRack' => ['isChecked' => false],
        'IVCRack' => ['isChecked' => false],
        'positiveRack' => ['isChecked' => true, 'per' => 0, 'times' => 3],
        'negativeRack' => ['isChecked' => false],
        'oneWayAirflowRack' => ['isChecked' => true, 'per' => 4, 'times' => 2],
        'isolator' => ['isChecked' => false]
      ],
      'Q4' => 1,
      'Q5' => 0,
      'Q6' => 2,
      'Q7' => [1],
      'Q8' => [0],
      'Q9' => [0, 1],
      'Q10' => [3],
      'Q11' => [0, 1],
      'Q12' => [1, 2, 4, 8, 11, 12],
      'Q13' => [0]
    ];
  }

  public function testRouteExists(): void
  {
    $routes = require __DIR__ . '/../../Routing/routes.php';
    $this->assertArrayHasKey('api/diagnosis', $routes);
    $this->assertArrayHasKey('POST', $routes['api/diagnosis']);
    $this->assertArrayHasKey('PUT', $routes['api/diagnosis']);
  }

  public function testPostRouteFunction(): void
  {
    // ルートの取得
    $routes = require __DIR__ . '/../../Routing/routes.php';
    $postRoute = $routes['api/diagnosis']['POST'];

    // file_get_contentsをモック
    $this->mockFileGetContents(json_encode($this->validDiagnosisData));

    // ルート関数の実行
    $result = $postRoute();

    // 検証
    $this->assertInstanceOf(HTTPRenderer::class, $result);
    $content = $result->getContent();
    $decodedContent = json_decode($content, true);

    $this->assertArrayHasKey('message', $decodedContent);
    $this->assertEquals('success', $decodedContent['message']);
    $this->assertArrayHasKey('diagnosis', $decodedContent);
    $this->assertArrayHasKey('principle1', $decodedContent['diagnosis']);
    $this->assertArrayHasKey('principle2', $decodedContent['diagnosis']);
    $this->assertArrayHasKey('principle3', $decodedContent['diagnosis']);
    $this->assertArrayHasKey('principle4', $decodedContent['diagnosis']);
    $this->assertArrayHasKey('principle5', $decodedContent['diagnosis']);
    $this->assertArrayHasKey('principleDP', $decodedContent['diagnosis']);
  }

  public function testPutRouteFunction(): void
  {
    // ルートの取得
    $routes = require __DIR__ . '/../../Routing/routes.php';
    $putRoute = $routes['api/diagnosis']['PUT'];

    // file_get_contentsをモック
    $this->mockFileGetContents(json_encode($this->validDiagnosisData));

    // ルート関数の実行
    $result = $putRoute();

    // 検証
    $this->assertInstanceOf(HTTPRenderer::class, $result);
    $content = $result->getContent();
    $decodedContent = json_decode($content, true);

    $this->assertArrayHasKey('diagnosis', $decodedContent);
  }

  public function testPostRouteWithInvalidData(): void
  {
    // ルートの取得
    $routes = require __DIR__ . '/../../Routing/routes.php';
    $postRoute = $routes['api/diagnosis']['POST'];

    // Q1を欠落させた無効なデータ
    $invalidData = $this->validDiagnosisData;
    unset($invalidData['Q1']);

    // file_get_contentsをモック
    $this->mockFileGetContents(json_encode($invalidData));

    // 例外を期待
    $this->expectException(InvalidArgumentException::class);
    $this->expectExceptionMessage('The provided value is not a valid data.');

    // ルート関数の実行
    $postRoute();
  }

  private function mockFileGetContents(string $returnValue): void
  {
    // グローバル関数のモックを設定
    global $mockFileGetContents;
    $mockFileGetContents = $returnValue;
  }
}

// file_get_contents関数のオーバーライド
namespace Routing;

function file_get_contents($filename)
{
  if ($filename === 'php://input') {
    global $mockFileGetContents;
    return $mockFileGetContents;
  }
  return \file_get_contents($filename);
}
