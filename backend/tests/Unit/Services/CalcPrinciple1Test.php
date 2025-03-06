<?php

namespace Tests\Unit\Services;

use PHPUnit\Framework\TestCase;
use App\Services\CalcPrinciple1;

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

    $this->assertEquals(7.5, $score);
  }

  public function testCheckedRack_WithoutParameters()
  {
    $this->expectException(\Exception::class);

    $data = [
      'Q3' => [
        'openRack' => ['isChecked' => false],
        'IVCRack' => ['isChecked' => false],
        'positiveRack' => ['isChecked' => true], //Missing parameters
        'negativeRack' => ['isChecked' => false],
        'oneWayAirflowRack' => ['isChecked' => true, 'per' => 4, 'times' => 2],
        'isolator' => ['isChecked' => false]
      ],
      'Q13' => [0]
    ];

    $principle1 = new CalcPrinciple1($data);
    $principle1->calculate();
  }

  public function testCalcQ3_EmptyData()
  {
    $this->expectException(\Exception::class);

    $data = [
      'Q3' => [],
      'Q13' => [0]
    ];

    $principle1 = new CalcPrinciple1($data);
    $principle1->calculate();
  }

  public function testCalcQ13_EmptyData()
  {
    $this->expectException(\Exception::class);

    $data = [
      'Q3' => [
        'openRack' => ['isChecked' => false],
        'IVCRack' => ['isChecked' => false],
        'positiveRack' => ['isChecked' => true, 'per' => 0, 'times' => 3],
        'negativeRack' => ['isChecked' => false],
        'oneWayAirflowRack' => ['isChecked' => true, 'per' => 4, 'times' => 2],
        'isolator' => ['isChecked' => false]
      ],
      'Q13' => []
    ];

    $principle1 = new CalcPrinciple1($data);
    $principle1->calculate();
  }

  public function testConstructor_MissingQ3()
  {
    $this->expectException(\Exception::class);

    $incompleteData = [
      'Q13' => [0]
    ];

    new CalcPrinciple1($incompleteData);
  }

  public function testConstructor_MissingQ13()
  {
    $this->expectException(\Exception::class);

    $incompleteData = [
      'Q3' => [
        'openRack' => ['isChecked' => false],
        'IVCRack' => ['isChecked' => false],
        'positiveRack' => ['isChecked' => true, 'per' => 0, 'times' => 3],
        'negativeRack' => ['isChecked' => false],
        'oneWayAirflowRack' => ['isChecked' => true, 'per' => 4, 'times' => 2],
        'isolator' => ['isChecked' => false]
      ]
    ];

    new CalcPrinciple1($incompleteData);
  }

  public function testCalcQ3_AllRacksFalse()
  {
    $this->expectException(\Exception::class);

    $data = [
      'Q3' => [
        'openRack' => ['isChecked' => false],
        'IVCRack' => ['isChecked' => false],
        'positiveRack' => ['isChecked' => false],
        'negativeRack' => ['isChecked' => false],
        'oneWayAirflowRack' => ['isChecked' => false],
        'isolator' => ['isChecked' => false]
      ],
      'Q13' => [0]
    ];

    $principle1 = new CalcPrinciple1($data);
    $principle1->calculate();
  }

  public function testQ13_TooManyValues()
  {
    $this->expectException(\Exception::class);
    $this->expectExceptionMessage("Q13 array must contain 2 or fewer values");

    $data = [
      'Q3' => [
        'openRack' => ['isChecked' => false],
        'IVCRack' => ['isChecked' => false],
        'positiveRack' => ['isChecked' => true, 'per' => 0, 'times' => 3],
        'negativeRack' => ['isChecked' => false],
        'oneWayAirflowRack' => ['isChecked' => true, 'per' => 4, 'times' => 2],
        'isolator' => ['isChecked' => false]
      ],
      'Q13' => [0, 1, 2] //too many values
    ];

    $principle1 = new CalcPrinciple1($data);
    $principle1->calculate();
  }

  public function testInvalidDynamicPointValue()
  {
    $this->expectException(\Exception::class);

    $data = [
      'Q3' => [
        'openRack' => ['isChecked' => false],
        'IVCRack' => ['isChecked' => false],
        'positiveRack' => ['isChecked' => true, 'per' => 0, 'times' => 3],
        'negativeRack' => ['isChecked' => false],
        'oneWayAirflowRack' => ['isChecked' => true, 'per' => 4, 'times' => 99], //invalid value
        'isolator' => ['isChecked' => false]
      ],
      'Q13' => [-1] //invalid value
    ];

    $principle1 = new CalcPrinciple1($data);
    $principle1->calculate();
  }

  public function testNullPerParameter()
  {
    $this->expectException(\Exception::class);

    $data = [
      'Q3' => [
        'positiveRack' => ['isChecked' => true, 'per' => null, 'times' => 3],
      ],
      'Q13' => [0]
    ];

    $principle1 = new CalcPrinciple1($data);
    $principle1->calculate();
  }

  public function testNullTimesParameter()
  {
    $this->expectException(\Exception::class);

    $data = [
      'Q3' => [
        'positiveRack' => ['isChecked' => true, 'per' => 0, 'times' => null],
      ],
      'Q13' => [0]
    ];

    $principle1 = new CalcPrinciple1($data);
    $principle1->calculate();
  }
}
