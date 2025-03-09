<?php

use App\Services\CalcPrinciple2;
use PHPUnit\Framework\TestCase;

class CalcPrinciple2Test extends TestCase
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
      'Q5' => 0,
      'Q6' => 2,
      'Q7' => [1],
      'Q8' => [0],
    ];

    $principle2 = new CalcPrinciple2($data);
    $score = $principle2->calculate();

    $this->assertEquals(6.94, $score);
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
        'positiveRack' => ['isChecked' => true],
        'negativeRack' => ['isChecked' => false],
        'oneWayAirflowRack' => ['isChecked' => true, 'per' => 4, 'times' => 2],
        'isolator' => ['isChecked' => false]
      ],
      'Q5' => 0,
      'Q6' => 2,
      'Q7' => [1],
      'Q8' => [0],
    ];

    $principle2 = new CalcPrinciple2($data);
    $principle2->calculate();
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
      'Q5' => 0,
      'Q6' => 2,
      'Q7' => [1],
      'Q8' => [0],
    ];

    $principle2 = new CalcPrinciple2($data);
    $principle2->calculate();
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
      'Q5' => 0,
      'Q6' => 2,
      'Q7' => [1],
      'Q8' => [0],
    ];

    $principle2 = new CalcPrinciple2($data);
    $principle2->calculate();
  }
  public function testCalcQ3_EmptyData()
  {
    $this->expectException(\Exception::class);

    $data = [
      'Q1' => [0],
      'Q2' => [0, 1],
      'Q3' => [],
      'Q5' => 0,
      'Q6' => 2,
      'Q7' => [1],
      'Q8' => [0],
    ];

    $principle2 = new CalcPrinciple2($data);
    $principle2->calculate();
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
      'Q5' => 0,
      'Q6' => 2,
      'Q7' => [],
      'Q8' => [0],
    ];

    $principle2 = new CalcPrinciple2($data);
    $principle2->calculate();
  }
  public function testCalcQ8_EmptyData()
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
      'Q8' => [],
    ];

    $principle2 = new CalcPrinciple2($data);
    $principle2->calculate();
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
      'Q5' => 0,
      'Q6' => 2,
      'Q7' => [1],
      'Q8' => [0],
    ];

    $principle2 = new CalcPrinciple2($data);
    $principle2->calculate();
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
      'Q5' => 0,
      'Q6' => 2,
      'Q7' => [1],
      'Q8' => [0],
    ];

    new CalcPrinciple2($data);
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
      'Q5' => 0,
      'Q6' => 2,
      'Q7' => [1],
      'Q8' => [0],
    ];

    new CalcPrinciple2($data);
  }
  public function testConstructor_MissingQ3()
  {
    $this->expectException(\Exception::class);

    $data = [
      'Q1' => [0],
      'Q2' => [0, 1],
      'Q5' => 0,
      'Q6' => 2,
      'Q7' => [1],
      'Q8' => [0],
    ];

    new CalcPrinciple2($data);
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
      'Q6' => 2,
      'Q7' => [1],
      'Q8' => [0],
    ];

    new CalcPrinciple2($data);
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
      'Q5' => 0,
      'Q7' => [1],
      'Q8' => [0],
    ];

    new CalcPrinciple2($data);
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
      'Q5' => 0,
      'Q6' => 2,
      'Q8' => [0],
    ];

    new CalcPrinciple2($data);
  }
  public function testConstructor_MissingQ8()
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
    ];

    new CalcPrinciple2($data);
  }

  /**
   * invalid value
   */
  public function testQ1_InvalidWeightingValue()
  {
    $this->expectException(\Exception::class);
    $data = [
      'Q1' => [99],
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
      'Q8' => [0],
    ];

    $principle2 = new CalcPrinciple2($data);
    $principle2->calculate();
  }
  public function testQ2_InvalidWeightingValue()
  {
    $this->expectException(\Exception::class);
    $data = [
      'Q1' => [0],
      'Q2' => [0, 99],
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
      'Q8' => [0],
    ];

    $principle2 = new CalcPrinciple2($data);
    $principle2->calculate();
  }
  public function testQ3_InvalidWeightingValue()
  {
    $this->expectException(\Exception::class);
    $data = [
      'Q1' => [0],
      'Q2' => [0, 1],
      'Q3' => [
        'openRack' => ['isChecked' => false],
        'IVCRack' => ['isChecked' => false],
        'positiveRack' => ['isChecked' => true, 'per' => 99, 'times' => 3],
        'negativeRack' => ['isChecked' => false],
        'oneWayAirflowRack' => ['isChecked' => true, 'per' => 4, 'times' => 2],
        'isolator' => ['isChecked' => false]
      ],
      'Q5' => 0,
      'Q6' => 2,
      'Q7' => [1],
      'Q8' => [0],
    ];

    $principle2 = new CalcPrinciple2($data);
    $principle2->calculate();
  }
  public function testQ5_InvalidWeightingValue()
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
      'Q5' => 99,
      'Q6' => 2,
      'Q7' => [1],
      'Q8' => [0],
    ];

    $principle2 = new CalcPrinciple2($data);
    $principle2->calculate();
  }
  public function testQ6_InvalidWeightingValue()
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
      'Q6' => 99,
      'Q7' => [1],
      'Q8' => [0],
    ];

    $principle2 = new CalcPrinciple2($data);
    $principle2->calculate();
  }
  public function testQ7_InvalidWeightingValue()
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
      'Q7' => [99],
      'Q8' => [0],
    ];

    $principle2 = new CalcPrinciple2($data);
    $principle2->calculate();
  }
  public function testQ8_InvalidWeightingValue()
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
      'Q8' => [99],
    ];

    $principle2 = new CalcPrinciple2($data);
    $principle2->calculate();
  }

  /**
   * check null
   */
  public function testQ1_NullElement()
  {
    $this->expectException(\Exception::class);
    $data = [
      'Q1' => [null],
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
      'Q8' => [0],
    ];

    $principle2 = new CalcPrinciple2($data);
    $principle2->calculate();
  }
  public function testQ2_NullElement()
  {
    $this->expectException(\Exception::class);
    $data = [
      'Q1' => [0],
      'Q2' => [null],
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
      'Q8' => [0],
    ];

    $principle2 = new CalcPrinciple2($data);
    $principle2->calculate();
  }
  public function testQ3_NullPerParameter()
  {
    $this->expectException(\Exception::class);
    $data = [
      'Q1' => [0],
      'Q2' => [0, 1],
      'Q3' => [
        'openRack' => ['isChecked' => false],
        'IVCRack' => ['isChecked' => false],
        'positiveRack' => ['isChecked' => true, 'per' => 0, 'times' => null],
        'negativeRack' => ['isChecked' => false],
        'oneWayAirflowRack' => ['isChecked' => true, 'per' => 4, 'times' => 2],
        'isolator' => ['isChecked' => false]
      ],
      'Q5' => 0,
      'Q6' => 2,
      'Q7' => [1],
      'Q8' => [0],
    ];

    $principle2 = new CalcPrinciple2($data);
    $principle2->calculate();
  }
  public function testQ3_NullTimesParameter()
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
        'oneWayAirflowRack' => ['isChecked' => true, 'per' => 4, 'times' => null],
        'isolator' => ['isChecked' => false]
      ],
      'Q5' => 0,
      'Q6' => 2,
      'Q7' => [1],
      'Q8' => [0],
    ];

    $principle2 = new CalcPrinciple2($data);
    $principle2->calculate();
  }
  public function testQ5_NullElement()
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
      'Q5' => null,
      'Q6' => 2,
      'Q7' => [1],
      'Q8' => [0],
    ];

    $principle2 = new CalcPrinciple2($data);
    $principle2->calculate();
  }
  public function testQ6_NullElement()
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
      'Q6' => null,
      'Q7' => [1],
      'Q8' => [0],
    ];

    $principle2 = new CalcPrinciple2($data);
    $principle2->calculate();
  }
  public function testQ7_NullElement()
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
      'Q7' => [null],
      'Q8' => [0],
    ];

    $principle2 = new CalcPrinciple2($data);
    $principle2->calculate();
  }
  public function testQ8_NullElement()
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
      'Q8' => [null],
    ];

    $principle2 = new CalcPrinciple2($data);
    $principle2->calculate();
  }

  /**
   * check boundary
   */

  /**
   * invalid data types
   */
}
