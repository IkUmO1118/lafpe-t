<?php

namespace Tests\Unit\Controllers;

use PHPUnit\Framework\TestCase;
use App\Controllers\DiagnosisController;

class DiagnosisControllerTest extends TestCase
{
  public function testStore_FullData()
  {
    $data = [
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


    $controller = new DiagnosisController($data);
    $result = $controller->store();

    $this->assertIsArray($result);

    // 各原則のスコアが存在することを確認
    $expectedPrinciples = [
      'principle1',
      'principle2',
      'principle3',
      'principle4',
      'principle5',
      'principleDP'
    ];

    foreach ($expectedPrinciples as $principle) {
      $this->assertArrayHasKey($principle, $result);
      $this->assertIsFloat($result[$principle]);
    }
  }

  public function testStore_CalculationResults()
  {
    $data = [
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

    $controller = new DiagnosisController($data);
    $result = $controller->store();

    $this->assertIsArray($result);

    $expectedResults = [
      'principle1' => 7.50,
      'principle2' => 6.94,
      'principle3' => 5.76,
      'principle4' => 6.37,
      'principle5' => 2.00,
      'principleDP' => 5.00
    ];

    foreach ($expectedResults as $principle => $expectedValue) {
      $this->assertArrayHasKey($principle, $result);  // 各原則が結果に含まれているか
      $this->assertEqualsWithDelta($expectedValue, $result[$principle], 0.01);
    }
  }


  public function testUpdate_EmptyResult()
  {
    $data = [];
    $controller = new DiagnosisController($data);
    $result = $controller->update();

    $this->assertIsArray($result);
    $this->assertEmpty($result);
  }
}
