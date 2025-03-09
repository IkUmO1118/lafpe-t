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

  /**
   * missing questions
   */

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
