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
}
