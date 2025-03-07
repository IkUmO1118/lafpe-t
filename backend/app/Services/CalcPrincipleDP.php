<?php

namespace App\Services;

use App\Services\Contracts\AbstractPrinciple;
use Exception;

class CalcPrincipleDP extends AbstractPrinciple
{
  protected static ?string $principle = "principleDP";
  protected static array $questionList = ['Q4', 'Q11'];

  public function calculate(): float
  {
    $this->calcQ4();
    $this->calcQ11();

    return $this->getTotalScore();
  }

  public function calcQ4(): void
  {
    $resQ4 = $this->res['Q4'];

    if (!isset($resQ4) || $resQ4 === null) {
      throw new Exception("Q4 value cannot be null");
    }

    if (!is_int($resQ4) && !is_float($resQ4)) {
      throw new Exception("Q4 value must be numeric");
    }

    if (!isset($this->weightings["Q4"][$resQ4])) {
      throw new Exception("Invalid weighting value for Q4: {$resQ4}");
    }

    $this->addTotalScore($this->staticPoints["Q4"] * $this->weightings["Q4"][$resQ4]);
  }

  public function calcQ11(): void
  {
    $resQ11 = $this->res["Q11"];

    if (!isset($resQ11) || empty($resQ11)) {
      throw new Exception("Empty data for Q11");
    }

    if (count($resQ11) > 4) {
      throw new Exception("Too many values for Q11");
    }

    foreach ($resQ11 as $value) {
      if ($value === null || (!is_int($value) && !is_float($value))) {
        throw new Exception("Q11 array elementes cannot be null and must be numeric");
      }
    }

    $totalStaticScore = $this->staticPoints["Q11"] ?? 0;

    $totalWeighting = array_reduce(
      $resQ11,
      function ($acc, $cur) {
        if (!isset($this->weightings["Q11"][$cur])) {
          throw new Exception("Invalid weighting value for Q11: {$cur}");
        }
        return $acc + ($this->weightings["Q11"][$cur] ?? 0);
      },
      0
    );

    $this->addTotalScore($totalStaticScore * $totalWeighting);
  }
}
