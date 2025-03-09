<?php

use App\Services\CalcPrinciple3;
use PHPUnit\Framework\TestCase;

class CalcPrinciple3Test extends TestCase
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
      'Q4' => 1,
      'Q5' => 0,
      'Q6' => 2,
      'Q7' => [1],
      'Q8' => [0],
      'Q9' => [0, 1],
    ];

    $principle3 = new CalcPrinciple3($data);
    $score = $principle3->calculate();

    $this->assertEquals(5.76, $score);
  }

  public function testCalcQ3_WithoutParameters()
  {
    $this->expectException(\Exception::class);

    $data = [
      'Q3' => [
        'openRack' => ['isChecked' => false],
        'IVCRack' => ['isChecked' => false],
        'positiveRack' => ['isChecked' => true],
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
    ];

    $principle3 = new CalcPrinciple3($data);
    $principle3->calculate();
  }

  /**
   * empty data
   */
  public function testCalcQ3_EmptyData()
  {
    $this->expectException(\Exception::class);

    $data = [
      'Q3' => [],
      'Q4' => 1,
      'Q5' => 0,
      'Q6' => 2,
      'Q7' => [1],
      'Q8' => [0],
      'Q9' => [0, 1],
    ];

    $principle3 = new CalcPrinciple3($data);
    $principle3->calculate();
  }
  public function testCalcQ7_EmptyData()
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
      'Q4' => 1,
      'Q5' => 0,
      'Q6' => 2,
      'Q7' => [],
      'Q8' => [0],
      'Q9' => [0, 1],
    ];

    $principle3 = new CalcPrinciple3($data);
    $principle3->calculate();
  }
  public function testCalcQ8_EmptyData()
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
      'Q4' => 1,
      'Q5' => 0,
      'Q6' => 2,
      'Q7' => [1],
      'Q8' => [],
      'Q9' => [0, 1],
    ];

    $principle3 = new CalcPrinciple3($data);
    $principle3->calculate();
  }
  public function testCalcQ9_EmptyData()
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
      'Q4' => 1,
      'Q5' => 0,
      'Q6' => 2,
      'Q7' => [],
      'Q8' => [0],
      'Q9' => [],
    ];

    $principle3 = new CalcPrinciple3($data);
    $principle3->calculate();
  }

  /**
   * all racks are false
   */
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
      'Q4' => 1,
      'Q5' => 0,
      'Q6' => 2,
      'Q7' => [1],
      'Q8' => [0],
      'Q9' => [0, 1],
    ];

    $principle3 = new CalcPrinciple3($data);
    $principle3->calculate();
  }

  /**
   * missing questions
   */
  public function testConstructor_MissingQ3()
  {
    $this->expectException(\Exception::class);

    $data = [
      'Q4' => 1,
      'Q5' => 0,
      'Q6' => 2,
      'Q7' => [1],
      'Q8' => [0],
      'Q9' => [0, 1],
    ];

    new CalcPrinciple3($data);
  }
  public function testConstructor_MissingQ4()
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
      'Q5' => 0,
      'Q6' => 2,
      'Q7' => [1],
      'Q8' => [0],
      'Q9' => [0, 1],
    ];

    new CalcPrinciple3($data);
  }
  public function testConstructor_MissingQ5()
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
      'Q4' => 1,
      'Q6' => 2,
      'Q7' => [1],
      'Q8' => [0],
      'Q9' => [0, 1],
    ];

    new CalcPrinciple3($data);
  }
  public function testConstructor_MissingQ6()
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
      'Q4' => 1,
      'Q5' => 0,
      'Q7' => [1],
      'Q8' => [0],
      'Q9' => [0, 1],
    ];

    new CalcPrinciple3($data);
  }
  public function testConstructor_MissingQ7()
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
      'Q4' => 1,
      'Q5' => 0,
      'Q6' => 2,
      'Q8' => [0],
      'Q9' => [0, 1],
    ];

    new CalcPrinciple3($data);
  }
  public function testConstructor_MissingQ8()
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
      'Q4' => 1,
      'Q5' => 0,
      'Q6' => 2,
      'Q7' => [1],
      'Q9' => [0, 1],
    ];

    new CalcPrinciple3($data);
  }
  public function testConstructor_MissingQ9()
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
      'Q4' => 1,
      'Q5' => 0,
      'Q6' => 2,
      'Q8' => [0],
    ];

    new CalcPrinciple3($data);
  }

  /**
   * invalid value
   */
  public function testQ3_InvalidWeightingValue() {}
  public function testQ4_InvalidWeightingValue() {}
  public function testQ5_InvalidWeightingValue() {}
  public function testQ6_InvalidWeightingValue() {}
  public function testQ7_InvalidWeightingValue() {}
  public function testQ8_InvalidWeightingValue() {}
  public function testQ9_InvalidWeightingValue() {}

  /**
   * check null
   */
  public function testQ2_NullElement() {}
  public function testQ3_NullPerParameter() {}
  public function testQ3_NullTimesParameter() {}
  public function testQ4_NullElement() {}
  public function testQ5_NullElement() {}
  public function testQ6_NullElement() {}
  public function testQ7_NullElement() {}
  public function testQ8_NullElement() {}
  public function testQ9_NullElement() {}

  /**
   * check boundary
   */
  public function testQ7_TooManyValues() {}
  public function testQ8_TooManyValues() {}
  public function testQ9_TooManyValues() {}

  public function testQ7_ExactlyFourValues() {}
  public function testQ8_ExactlyFourValues() {}
  public function testQ9_ExactlyFourValues() {}

  public function testQ4_MinValue() {}
  public function testQ4_MaxValue() {}
  public function testQ5_MinValue() {}
  public function testQ5_MaxValue() {}
  public function testQ6_MinValue() {}
  public function testQ6_MaxValue() {}

  /**
   * invalid data types
   */
  public function testQ3_InvalidDataType() {}
  public function testQ4_InvalidDataType() {}
  public function testQ5_InvalidDataType() {}
  public function testQ6_InvalidDataType() {}
  public function testQ7_InvalidDataType() {}
  public function testQ8_InvalidDataType() {}
  public function testQ9_InvalidDataType() {}
}
