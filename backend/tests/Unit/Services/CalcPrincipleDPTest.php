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

    $principleDP = new CalcPrincipleDP($data);
    $score = $principleDP->calculate();

    $this->assertEquals(5.0, $score);
  }

  public function testCalcQ11_EmptyData()
  {
    $this->expectException(\Exception::class);

    $data = [
      'Q4' => 1,
      'Q11' => [],
    ];

    $principleDP = new CalcPrincipleDP($data);
    $principleDP->calculate();
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

    $principleDP = new CalcPrincipleDP($data);
    $principleDP->calculate();
  }

  public function testQ4_InvalidWeightingValue()
  {
    $this->expectException(\Exception::class);

    $data = [
      'Q4' => 3, //invalid value
      'Q11' => [0, 1]
    ];

    $principleDP = new CalcPrincipleDP($data);
    $principleDP->calculate();
  }
  public function testQ11_InvalidWeightingValue()
  {
    $this->expectException(\Exception::class);

    $data = [
      'Q4' => 1,
      'Q11' => [0, 4] //invalid value
    ];

    $principleDP = new CalcPrincipleDP($data);
    $principleDP->calculate();
  }

  public function testQ4_NullElement()
  {
    $this->expectException(\Exception::class);

    $data = [
      'Q4' => null,
      'Q11' => [0, 1]
    ];

    $principleDP = new CalcPrincipleDP($data);
    $principleDP->calculate();
  }
  public function testQ11_NullElement()
  {
    $this->expectException(\Exception::class);

    $data = [
      'Q4' => 1,
      'Q11' => [null]
    ];

    $principleDP = new CalcPrincipleDP($data);
    $principleDP->calculate();
  }

  public function testQ11_ExactlyFourValues()
  {
    $data = [
      'Q4' => 1,
      'Q11' => [0, 1, 2, 3] //正確に4つの値
    ];

    $principleDP = new CalcPrincipleDP($data);
    $score = $principleDP->calculate();
    $this->assertIsFloat($score);
  }

  public function testQ4_MinValue()
  {
    $data = [
      'Q4' => 0, //min avalue
      'Q11' => [0, 1]
    ];

    $principleDP = new CalcPrincipleDP($data);
    $score = $principleDP->calculate();
    $this->assertIsFloat($score);
  }
  public function testQ4_MaxValue()
  {
    $data = [
      'Q4' => 2, //max value
      'Q11' => [0, 1]
    ];

    $principleDP = new CalcPrincipleDP($data);
    $score = $principleDP->calculate();
    $this->assertIsFloat($score);
  }

  public function testQ4_InvalidDataType()
  {
    $this->expectException(\Exception::class);

    $data = [
      'Q4' => '0',
      'Q11' => [0, 1]
    ];

    $principleDP = new CalcPrincipleDP($data);
    $principleDP->calculate();
  }
  public function testQ11_InvalidDataType()
  {
    $this->expectException(\Exception::class);

    $data = [
      'Q4' => 1,
      'Q11' => [0, "1"]
    ];

    $principleDP = new CalcPrincipleDP($data);
    $principleDP->calculate();
  }
}
