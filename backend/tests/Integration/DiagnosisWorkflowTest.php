<?php

namespace Tests\Integration;

use App\Controllers\DiagnosisController;
use App\Services\CalcPrinciple1;
use App\Services\CalcPrinciple2;
use App\Services\CalcPrinciple3;
use App\Services\CalcPrinciple4;
use App\Services\CalcPrinciple5;
use App\Services\CalcPrincipleDP;
use Exception;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class DiagnosisWorkflowTest extends TestCase
{
  private array $validDiagnosisData;

  protected function setUp(): void
  {
    parent::setUp();

    // 有効なダイアグノーシスデータを設定
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

  public function testDiagnosisControllerStore(): void
  {
    $controller = new DiagnosisController($this->validDiagnosisData);
    $result = $controller->store();

    $this->assertIsArray($result);
    $this->assertArrayHasKey('principle1', $result);
    $this->assertArrayHasKey('principle2', $result);
    $this->assertArrayHasKey('principle3', $result);
    $this->assertArrayHasKey('principle4', $result);
    $this->assertArrayHasKey('principle5', $result);
    $this->assertArrayHasKey('principleDP', $result);

    $this->assertIsFloat($result['principle1']);
    $this->assertIsFloat($result['principle2']);
    $this->assertIsFloat($result['principle3']);
    $this->assertIsFloat($result['principle4']);
    $this->assertIsFloat($result['principle5']);
    $this->assertIsFloat($result['principleDP']);
  }

  public function testMissingRequiredQuestion(): void
  {
    $invalidData = $this->validDiagnosisData;
    unset($invalidData['Q1']);

    $this->expectException(Exception::class);
    $controller = new DiagnosisController($invalidData);
    $controller->store();
  }

  public function testInvalidQ3Format(): void
  {
    $invalidData = $this->validDiagnosisData;
    // Q3のopenRackに必要なフィールドが欠けている
    $invalidData['Q3']['openRack'] = [
      'isChecked' => true,
      // perとtimesが欠けている
    ];

    $this->expectException(Exception::class);
    $controller = new DiagnosisController($invalidData);
    $controller->store();
  }

  public function testCalcPrinciple1(): void
  {
    $principle1Data = array_intersect_key($this->validDiagnosisData, array_flip(['Q3', 'Q13']));
    $principle1 = new CalcPrinciple1($principle1Data);
    $result = $principle1->calculate();

    $this->assertIsFloat($result);
    $this->assertEquals(7.5, $result);
  }

  public function testCalcPrinciple2(): void
  {
    $principle2Data = array_intersect_key($this->validDiagnosisData, array_flip(['Q1', 'Q2', 'Q3', 'Q5', 'Q6', 'Q7', 'Q8']));
    $principle2 = new CalcPrinciple2($principle2Data);
    $result = $principle2->calculate();

    $this->assertIsFloat($result);
    $this->assertEquals(6.94, $result);
  }

  public function testCalcPrinciple3(): void
  {
    $principle3Data = array_intersect_key($this->validDiagnosisData, array_flip(['Q3', 'Q4', 'Q5', 'Q6', 'Q7', 'Q8', 'Q9']));
    $principle3 = new CalcPrinciple3($principle3Data);
    $result = $principle3->calculate();

    $this->assertIsFloat($result);
    $this->assertEquals(5.76, $result);
  }

  public function testCalcPrinciple4(): void
  {
    $principle4Data = array_intersect_key($this->validDiagnosisData, array_flip(['Q1', 'Q2', 'Q3', 'Q4', 'Q5', 'Q6', 'Q7', 'Q10']));
    $principle4 = new CalcPrinciple4($principle4Data);
    $result = $principle4->calculate();

    $this->assertIsFloat($result);
    $this->assertEquals(6.37, $result);
  }

  public function testCalcPrinciple5(): void
  {
    $principle5Data = array_intersect_key($this->validDiagnosisData, array_flip(['Q3', 'Q12']));
    $principle5 = new CalcPrinciple5($principle5Data);
    $result = $principle5->calculate();

    $this->assertIsFloat($result);
    $this->assertEquals(2.00, $result);
  }

  public function testCalcPrincipleDP(): void
  {
    $principleDPData = array_intersect_key($this->validDiagnosisData, array_flip(['Q4', 'Q11']));
    $principleDP = new CalcPrincipleDP($principleDPData);
    $result = $principleDP->calculate();

    $this->assertIsFloat($result);
    $this->assertEquals(05.00, $result);
  }

  public function testFullWorkflow(): void
  {
    // 1. ValidationHelperを使ってデータを検証
    $validatedData = \Helpers\ValidationHelper::checkRequiredQuestions($this->validDiagnosisData);

    // 2. DiagnosisControllerを使って計算
    $controller = new DiagnosisController($validatedData);
    $result = $controller->store();

    // 3. JSONRendererを使ってJSONに変換
    $renderer = new \Response\Render\JSONRenderer(["message" => "success", 'diagnosis' => $result]);
    $jsonContent = $renderer->getContent();
    $decodedContent = json_decode($jsonContent, true);

    // 検証
    $this->assertEquals("success", $decodedContent['message']);
    $this->assertArrayHasKey('diagnosis', $decodedContent);
    $this->assertArrayHasKey('principle1', $decodedContent['diagnosis']);
    $this->assertArrayHasKey('principle2', $decodedContent['diagnosis']);
    $this->assertArrayHasKey('principle3', $decodedContent['diagnosis']);
    $this->assertArrayHasKey('principle4', $decodedContent['diagnosis']);
    $this->assertArrayHasKey('principle5', $decodedContent['diagnosis']);
    $this->assertArrayHasKey('principleDP', $decodedContent['diagnosis']);
  }
}
