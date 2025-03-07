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
      'Q12' => [1, 2, 4, 8, 11, 12],
    ];

    $principle5 = new CalcPrinciple5($data);
    $principle5->calculate();
  }

  public function testCalcQ3_EmptyData()
  {
    $this->expectException(\Exception::class);

    $data = [
      'Q3' => [],
      'Q12' => [1, 2, 4, 8, 11, 12],
    ];

    $principle5 = new CalcPrinciple5($data);
    $principle5->calculate();
  }
  public function testCalcQ12_EmptyData()
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
      'Q12' => []
    ];

    $principle5 = new CalcPrinciple5($data);
    $principle5->calculate();
  }

  public function testConstructor_MissingQ3()
  {
    $this->expectException(\Exception::class);

    $incompleteData = [
      'Q12' => [1, 2, 4, 8, 11, 12]
    ];

    new CalcPrinciple5($incompleteData);
  }
  public function testConstructor_MissingQ12()
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
    ];

    new CalcPrinciple5($data);
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
      'Q12' => [1, 2, 4, 8, 11, 12]
    ];

    $principle5 = new CalcPrinciple5($data);
    $principle5->calculate();
  }

  public function testQ12_TooManyValues()
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
      "Q12" => [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15] //too many values
    ];

    $principle5 = new CalcPrinciple5($data);
    $principle5->calculate();
  }

  public function testQ3_InvalidWeightingValue()
  {
    $this->expectException(\Exception::class);

    $data = [
      'Q3' => [
        'openRack' => ['isChecked' => false],
        'IVCRack' => ['isChecked' => false],
        'positiveRack' => ['isChecked' => true, 'per' => 0, 'times' => 3],
        'negativeRack' => ['isChecked' => false],
        'oneWayAirflowRack' => ['isChecked' => true, 'per' => 4, 'times' => 99], //Invalid value
        'isolator' => ['isChecked' => false]
      ],
      'Q12' => [1, 2, 4, 8, 11, 12],
    ];

    $principle5 = new CalcPrinciple5($data);
    $principle5->calculate();
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
      'Q12' => [1, 2, 4, 8, 11, 12]
    ];

    $principle5 = new CalcPrinciple5($data);
    $principle5->calculate();
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
      'Q12' => [1, 2, 4, 8, 11, 12]
    ];

    $principle5 = new CalcPrinciple5($data);
    $principle5->calculate();
  }
  public function testQ12_NullElement()
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
      'Q12' => [null],
    ];

    $principle5 = new CalcPrinciple5($data);
    $principle5->calculate();
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
      'Q12' => [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14] // 正確に15つの値
    ];
    $principle5 = new CalcPrinciple5($data);
    $score = $principle5->calculate();
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
      'Q12' => [1, 2, 4, 8, 11, 12]
    ];
    $principle5 = new CalcPrinciple5($data);
    $score = $principle5->calculate();
    $this->assertIsFloat($score);
  }

  public function testQ3_InvalidDataTypes()
  {
    $this->expectException(\Exception::class);
    $data = [
      'Q3' => [
        'openRack' => ['isChecked' => false],
        'IVCRack' => ['isChecked' => false],
        'positiveRack' => ['isChecked' => true, 'per' => "Invalid", 'times' => "3"], //文字列
        'negativeRack' => ['isChecked' => false],
        'oneWayAirflowRack' => ['isChecked' => true, 'per' => 4, 'times' => 2],
        'isolator' => ['isChecked' => false]
      ],
      'Q12' => [1, 2, 4, 8, 11, 12]
    ];
    $principle5 = new CalcPrinciple5($data);
    $principle5->calculate();
  }

  public function testQ12_InvalidDataTypes()
  {
    $this->expectException(\Exception::class);
    $data = [
      'Q3' => [
        'openRack' => ['isChecked' => false],
        'IVCRack' => ['isChecked' => false],
        'positiveRack' => ['isChecked' => true, 'per' => 0, 'times' => 3], //文字列
        'negativeRack' => ['isChecked' => false],
        'oneWayAirflowRack' => ['isChecked' => true, 'per' => 4, 'times' => 2],
        'isolator' => ['isChecked' => false]
      ],
      'Q12' => ["1", "2", "4", "8", "11", "12"]
    ];
    $principle5 = new CalcPrinciple5($data);
    $principle5->calculate();
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
      'Q12' => [1, 2, 4, 8, 11, 12]
    ];

    $principle5 = new CalcPrinciple5($data);
    $principle5->calculate();
  }
}
