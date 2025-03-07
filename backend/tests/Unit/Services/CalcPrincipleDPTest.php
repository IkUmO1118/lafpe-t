<?php

namespace Tests\Unit\Services;

use App\Services\CalcPrincipleDP;
use PHPUnit\Framework\TestCase;

class CalcPrincipleDPTest extends TestCase
{
  public function testCalculate_FullData()
  {
    $data = [
      'Q4' => 1,
      'Q11' => [0, 1],
    ];

    $principle1 = new CalcPrincipleDP($data);
    $score = $principle1->calculate();

    $this->assertEquals(5.0, $score);
  }

  public function testCalcQ11_EmptyData()
  {
    $this->expectException(\Exception::class);

    $data = [
      'Q4' => 1,
      'Q11' => [],
    ];

    $principle1 = new CalcPrincipleDP($data);
    $principle1->calculate();
  }

  public function testConstructor_MissingQ4()
  {
    $this->expectException(\Exception::class);

    $data = [
      'Q11' => [0, 1],
    ];

    new CalcPrincipleDP($data);
  }

  public function testConstructor_MissingQ11()
  {
    $this->expectException(\Exception::class);

    $data = [
      'Q4' => 1,
    ];

    new CalcPrincipleDP($data);
  }

  public function testQ11_TooManyValues()
  {
    $this->expectException(\Exception::class);

    $data = [
      'Q4' => 1,
      'Q11' => [0, 1, 2, 3, 4] //too many values
    ];

    $principle1 = new CalcPrincipleDP($data);
    $principle1->calculate();
  }

  public function testQ4_InvalidDynamicPointValue()
  {
    $this->expectException(\Exception::class);

    $data = [
      'Q4' => 3, //invalid value
      'Q11' => [0, 1]
    ];

    $principle1 = new CalcPrincipleDP($data);
    $principle1->calculate();
  }

  public function testQ11_InvalidDynamicPointValue()
  {
    $this->expectException(\Exception::class);

    $data = [
      'Q4' => 3,
      'Q11' => [0, 4] //invalid value
    ];

    $principle1 = new CalcPrincipleDP($data);
    $principle1->calculate();
  }

  public function testQ4_NullElement()
  {
    $this->expectException(\Exception::class);

    $data = [
      'Q4' => null,
      'Q11' => [0, 4]
    ];

    $principle1 = new CalcPrincipleDP($data);
    $principle1->calculate();
  }

  public function test11_NullElement()
  {
    $this->expectException(\Exception::class);

    $data = [
      'Q4' => 1,
      'Q11' => [null]
    ];

    $principle1 = new CalcPrincipleDP($data);
    $principle1->calculate();
  }
}
