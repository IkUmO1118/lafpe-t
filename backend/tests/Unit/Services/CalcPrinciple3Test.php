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
