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

  public function testCalcQ3_WithoutParameters()
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
    $this->expectExceptionMessage("Too many values for Q13");

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

  public function testQ3_InvalidDynamicPointValue()
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
      'Q13' => [0, 1, 2]
    ];

    $principle1 = new CalcPrinciple1($data);
    $principle1->calculate();
  }

  public function testQ13_InvalidWeightingValue()
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
      'Q13' => [-1]
    ];

    $principle1 = new CalcPrinciple1($data);
    $principle1->calculate();
  }

  public function testQ3_NullPerParameter()
  {
    $this->expectException(\Exception::class);

    $data = [
      'Q3' => [
        'openRack' => ['isChecked' => false],
        'IVCRack' => ['isChecked' => false],
        'positiveRack' => ['isChecked' => true, 'per' => null, 'times' => 3],
        'negativeRack' => ['isChecked' => false],
        'oneWayAirflowRack' => ['isChecked' => true, 'per' => 4, 'times' => 2],
        'isolator' => ['isChecked' => false]
      ],
      'Q13' => [0]
    ];

    $principle1 = new CalcPrinciple1($data);
    $principle1->calculate();
  }

  public function testQ3_NullTimesParameter()
  {
    $this->expectException(\Exception::class);

    $data = [
      'Q3' => [
        'openRack' => ['isChecked' => false],
        'IVCRack' => ['isChecked' => false],
        'positiveRack' => ['isChecked' => true, 'per' => 0, 'times' => null],
        'negativeRack' => ['isChecked' => false],
        'oneWayAirflowRack' => ['isChecked' => true, 'per' => 4, 'times' => 2],
        'isolator' => ['isChecked' => false]
      ],
      'Q13' => [0]
    ];

    $principle1 = new CalcPrinciple1($data);
    $principle1->calculate();
  }

  public function testQ13_NullElement()
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
      'Q13' => [null]
    ];

    $principle1 = new CalcPrinciple1($data);
    $principle1->calculate();
  }

  public function testQ13_ExactlyTwoValues()
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
      'Q13' => [0, 1] // 正確に2つの値
    ];
    $principle1 = new CalcPrinciple1($data);
    $score = $principle1->calculate();
    $this->assertIsFloat($score);
  }

  public function testQ3_MinMaxValues()
  {
    $data = [
      'Q3' => [
        'openRack' => ['isChecked' => false],
        'IVCRack' => ['isChecked' => false],
        'positiveRack' => ['isChecked' => true, 'per' => 0, 'times' => 0], //最小値
        'negativeRack' => ['isChecked' => false],
        'oneWayAirflowRack' => ['isChecked' => true, 'per' => 4, 'times' => 3], //最大値
        'isolator' => ['isChecked' => false]
      ],
      'Q13' => [0]
    ];
    $principle1 = new CalcPrinciple1($data);
    $score = $principle1->calculate();
    $this->assertIsFloat($score);
  }

  public function testQ3_InvalidDataTypes()
  {
    $this->expectException(\Exception::class);
    $data = [
      'Q3' => [
        'openRack' => ['isChecked' => false],
        'IVCRack' => ['isChecked' => false],
        'positiveRack' => ['isChecked' => true, 'per' => "invalid", 'times' => "3"], // 文字列型
        'negativeRack' => ['isChecked' => false],
        'oneWayAirflowRack' => ['isChecked' => true, 'per' => 4, 'times' => 2],
        'isolator' => ['isChecked' => false]
      ],
      'Q13' => [0]
    ];
    $principle1 = new CalcPrinciple1($data);
    $principle1->calculate();
  }

  public function testQ13_InvalidDataTypes()
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
      'Q13' => ["0"]
    ];
    $principle1 = new CalcPrinciple1($data);
    $principle1->calculate();
  }

  public function testQ3_MissingRequiredRacks()
  {
    $this->expectException(\Exception::class);
    $this->expectExceptionMessage("Missing required racks in Q3");

    $data = [
      'Q3' => [
        'openRack' => ['isChecked' => false],
        'IVCRack' => ['isChecked' => false],
        'positiveRack' => ['isChecked' => true, 'per' => 0, 'times' => 3],
        'negativeRack' => ['isChecked' => false],
        // oneWayAirflowRack is missing
        'isolator' => ['isChecked' => false]
      ],
      'Q13' => [0]
    ];

    $principle1 = new CalcPrinciple1($data);
    $principle1->calculate();
  }
}
