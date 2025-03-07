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
   * Too many values
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

  /**
   * invalid value
   */

  /**
   * check null
   */

  /**
   * check boundary
   */

  /**
   * invalid data types
   */
}
