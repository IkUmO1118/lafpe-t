<?php

namespace Tests\Unit\Services;

use App\Services\CalcPrinciple5;
use PHPUnit\Framework\TestCase;

class CalcPrinciple5Test extends TestCase
{
  public function testCalculate_FullData()
  {
    $data = [
      'Q3' => [
        'openRack' => ['isChecked' => false],
        'IVCRack' => ['isChecked' => false],
        'positiveRack' => ['isChecked' => true, 'per' => 0, 'times' => 3],
        'negativeRack' => ['isChecked' => false],
        'oneWayAirflowRack' => ['isChecked' => true, 'per' => 4, 'times' => 2],
        'isolator' => ['isChecked' => false]
      ],
      'Q12' => [1, 2, 4, 8, 11, 12],
    ];

    $principle5 = new CalcPrinciple5($data);
    $score = $principle5->calculate();

    $this->assertEquals(2.0, $score);
  }
}
