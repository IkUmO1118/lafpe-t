<?php

namespace Tests\Unit\Services;

use PHPUnit\Framework\TestCase;
use App\Services\CalcPrinciple1;
use ReflectionClass;

class CalcPrinciple1Test extends TestCase
{
  private function invokeMethod(&$object, $methodName, array $parameters = [])
  {
    $reflection = new ReflectionClass(get_class($object));
    $method = $reflection->getMethod($methodName);
    $method->setAccessible(true);
    return $method->invokeArgs($object, $parameters);
  }

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

  public function testConstructor_MissingQuestion()
  {
    $this->expectException(\Exception::class);

    $incompleteData = [
      'Q13' => [0] // Missing Q3
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
}
