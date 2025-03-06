<?php

namespace Tests\Unit\Services;

use PHPUnit\Framework\TestCase;
use App\Services\CalcPrinciple1;
use ReflectionClass;

class CalcPrinciple1Test extends TestCase
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
      'Q13' => [0]
    ];

    $principle1 = new CalcPrinciple1($data);
    $score = $principle1->calculate();

    $this->assertIsFloat($score);
  }
}
