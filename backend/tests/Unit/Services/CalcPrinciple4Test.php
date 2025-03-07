<?php

namespace Tests\Unit\Services;

use App\Services\CalcPrinciple4;
use PHPUnit\Framework\TestCase;

class CalcPrinciple4Test extends TestCase
{
  public function testCalculate_FullData()
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
      'Q10' => [3],
    ];

    $principle4 = new CalcPrinciple4($data);
    $score = $principle4->calculate();

    $this->assertEquals(6.37, $score);
  }

  public function testCalcQ3_WithoutParameters()
  {
    $this->expectException(\Exception::class);

    $data = [
      'Q1' => [0],
      'Q2' => [0, 1],
      'Q3' => [
        'openRack' => ['isChecked' => false],
        'IVCRack' => ['isChecked' => false],
        'positiveRack' => ['isChecked' => true], //Missing parameters
        'negativeRack' => ['isChecked' => false],
        'oneWayAirflowRack' => ['isChecked' => true, 'per' => 4, 'times' => 2],
        'isolator' => ['isChecked' => false]
      ],
      'Q4' => 1,
      'Q5' => 0,
      'Q6' => 2,
      'Q7' => [1],
      'Q10' => [3],
    ];

    $principle4 = new CalcPrinciple4($data);
    $principle4->calculate();
  }

  /**
   * empty data
   */
  public function testCalcQ1_EmptyData()
  {
    $this->expectException(\Exception::class);

    $data = [
      'Q1' => [],
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
      'Q10' => [3],
    ];

    $principle4 = new CalcPrinciple4($data);
    $principle4->calculate();
  }
  public function testCalcQ2_EmptyData()
  {
    $this->expectException(\Exception::class);

    $data = [
      'Q1' => [0],
      'Q2' => [],
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
      'Q10' => [3],
    ];

    $principle4 = new CalcPrinciple4($data);
    $principle4->calculate();
  }
  public function testCalcQ3_EmptyData()
  {
    $this->expectException(\Exception::class);

    $data = [
      'Q1' => [0],
      'Q2' => [0, 1],
      'Q3' => [],
      'Q4' => 1,
      'Q5' => 0,
      'Q6' => 2,
      'Q7' => [1],
      'Q10' => [3],
    ];

    $principle4 = new CalcPrinciple4($data);
    $principle4->calculate();
  }
  public function testCalcQ7_EmptyData()
  {
    $this->expectException(\Exception::class);

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
      'Q7' => [],
      'Q10' => [3],
    ];

    $principle4 = new CalcPrinciple4($data);
    $principle4->calculate();
  }
  public function testCalcQ10_EmptyData()
  {
    $this->expectException(\Exception::class);

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
      'Q10' => [],
    ];

    $principle4 = new CalcPrinciple4($data);
    $principle4->calculate();
  }

  /**
   * all racks are false
   */
  public function testCalcQ3_AllRacksFalse()
  {
    $this->expectException(\Exception::class);

    $data = [
      'Q1' => [0],
      'Q2' => [0, 1],
      'Q3' => [
        'openRack' => ['isChecked' => false],
        'IVCRack' => ['isChecked' => false],
        'positiveRack' => ['isChecked' => false],
        'negativeRack' => ['isChecked' => false],
        'oneWayAirflowRack' => ['isChecked' => false],
        'isolator' => ['isChecked' => false]
      ],
      'Q4' => 1,
      'Q5' => 0,
      'Q6' => 2,
      'Q7' => [1],
      'Q10' => [3],
    ];

    $principle4 = new CalcPrinciple4($data);
    $principle4->calculate();
  }

  /**
   * missing questions
   */
  public function testConstructor_MissingQ1()
  {
    $this->expectException(\Exception::class);

    $data = [
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
      'Q10' => [3],
    ];

    new CalcPrinciple4($data);
  }
  public function testConstructor_MissingQ2()
  {
    $this->expectException(\Exception::class);

    $data = [
      'Q1' => [0],
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
      'Q10' => [3],
    ];

    new CalcPrinciple4($data);
  }
  public function testConstructor_MissingQ3()
  {
    $this->expectException(\Exception::class);

    $data = [
      'Q1' => [0],
      'Q2' => [0, 1],
      'Q4' => 1,
      'Q5' => 0,
      'Q6' => 2,
      'Q7' => [1],
      'Q10' => [3],
    ];

    new CalcPrinciple4($data);
  }
  public function testConstructor_MissingQ4()
  {
    $this->expectException(\Exception::class);

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
      'Q5' => 0,
      'Q6' => 2,
      'Q7' => [1],
      'Q10' => [3],
    ];

    new CalcPrinciple4($data);
  }
  public function testConstructor_MissingQ5()
  {
    $this->expectException(\Exception::class);

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
      'Q6' => 2,
      'Q7' => [1],
      'Q10' => [3],
    ];

    new CalcPrinciple4($data);
  }
  public function testConstructor_MissingQ6()
  {
    $this->expectException(\Exception::class);

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
      'Q7' => [1],
      'Q10' => [3],
    ];

    new CalcPrinciple4($data);
  }
  public function testConstructor_MissingQ7()
  {
    $this->expectException(\Exception::class);

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
      'Q10' => [3],
    ];

    new CalcPrinciple4($data);
  }
  public function testConstructor_MissingQ10()
  {
    $this->expectException(\Exception::class);

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
    ];

    new CalcPrinciple4($data);
  }

  /**
   * invalid value
   */
  public function testQ1_InvalidWeightingValue() {}
  public function testQ2_InvalidWeightingValue() {}
  public function testQ3_InvalidWeightingValue() {}
  public function testQ4_InvalidWeightingValue() {}
  public function testQ5_InvalidWeightingValue() {}
  public function testQ6_InvalidWeightingValue() {}
  public function testQ7_InvalidWeightingValue() {}
  public function testQ10_InvalidWeightingValue() {}

  /**
   * check null
   */
  public function testQ1_NullElement() {}
  public function testQ2_NullElement() {}
  public function testQ3_NullPerParameter() {}
  public function testQ3_NullTimesParameter() {}
  public function testQ4_NullElement() {}
  public function testQ5_NullElement() {}
  public function testQ6_NullElement() {}
  public function testQ7_NullElement() {}
  public function testQ10_NullElement() {}

  /**
   * check boundary
   */
  public function testQ1_TooManyValues()
  {
    $this->expectException(\Exception::class);

    $data = [
      'Q1' => [0, 1, 2], //too many values
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
      'Q10' => [3],
    ];

    $principle4 = new CalcPrinciple4($data);
    $principle4->calculate();
  }
  public function testQ2_TooManyValues()
  {
    $this->expectException(\Exception::class);

    $data = [
      'Q1' => [0],
      'Q2' => [0, 1, 2], //too many values
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
      'Q10' => [3],
    ];

    $principle4 = new CalcPrinciple4($data);
    $principle4->calculate();
  }
  public function testQ7_TooManyValues()
  {
    $this->expectException(\Exception::class);

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
      'Q7' => [0, 1, 2], //too many values
      'Q10' => [3],
    ];

    $principle4 = new CalcPrinciple4($data);
    $principle4->calculate();
  }
  public function testQ10_TooManyValues()
  {
    $this->expectException(\Exception::class);

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
      'Q10' => [0, 1, 2, 3, 4], //too many values
    ];

    $principle4 = new CalcPrinciple4($data);
    $principle4->calculate();
  }

  public function testQ1_ExactlyTwoValues() {}
  public function testQ2_ExactlyTwoValues() {}
  public function testQ7_ExactlyTwoValues() {}
  public function testQ10_ExactlyFourValues() {}

  public function testQ3_MinMaxValues() {}

  public function testQ4_MinValue() {}
  public function testQ4_MaxValue() {}
  public function testQ5_MinValue() {}
  public function testQ5_MaxValue() {}
  public function testQ6_MinValue() {}
  public function testQ6_MaxValue() {}

  /**
   * invalid data types
   */
  public function testQ1_InvalidDataType() {}
  public function testQ2_InvalidDataType() {}
  public function testQ3_InvalidDataType() {}
  public function testQ4_InvalidDataType() {}
  public function testQ5_InvalidDataType() {}
  public function testQ6_InvalidDataType() {}
  public function testQ7_InvalidDataType() {}
  public function testQ10_InvalidDataType() {}
}
