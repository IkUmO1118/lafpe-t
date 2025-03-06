<?php

namespace App\Services;

use App\Services\Contracts\AbstractPrinciple;
use Exception;

class CalcPrinciple1 extends AbstractPrinciple
{
  protected static ?string $principle = "principle1";
  protected static array $questionList = ["Q3", "Q13"];

  public function calculate(): float
  {
    $this->calcQ3();
    $this->calcQ13();

    return $this->getTotalScore();
  }

  private function calcQ3(): void
  {
    $resQ3 = $this->res['Q3'];

    if (!isset($resQ3) || empty($resQ3)) {
      throw new \Exception("Empty data for Q3");
    }

    $totalStaticPoint = $this->staticPoints['Q3'] ?? 0;
    $totalDynamicPoint = 0;

    $this->addTotalScore($totalStaticPoint);

    $hasChecked = false;

    foreach ($resQ3 as $rackKey => $rackValue) {
      if ($rackValue['isChecked'] === null) {
        throw new \Exception("isChecked value cannot be null");
      }

      if (isset($rackValue['isChecked']) && $rackValue['isChecked']) {
        $hasChecked = true;
        if (!isset($rackValue['per']) || $rackValue['per'] === null || !is_numeric($rackValue['per'])) {
          throw new \Exception("Per value cannot be null and numeric for checked rack");
        }
        if (!isset($rackValue['times']) || $rackValue['times'] === null || !is_numeric($rackValue['times'])) {
          throw new \Exception("Times value cannot be null and numeric for checked rack");
        }

        $times = (int)$rackValue['times'];

        if (!isset($this->dynamicPoints['Q3'][$rackKey][$times])) {
          throw new Exception("Invalid value for rack {$rackKey}: times value {$times} not found in configuration");
        }

        $totalDynamicPoint += $this->dynamicPoints['Q3'][$rackKey][$times];
      }
    }

    if (!$hasChecked) {
      throw new Exception("At least one rack must be checked for Q3");
    }

    $this->addTotalScore($totalDynamicPoint);
  }

  private function calcQ13(): void
  {
    $resQ13 = $this->res['Q13'];

    if (!isset($resQ13) || empty($resQ13)) {
      throw new \Exception("Empty data for Q13");
    }
    if (count($resQ13) > 2) {
      throw new \Exception("Q13 array must contain 2 or fewer values");
    }
    foreach ($resQ13 as $value) {
      if ($value === null || (!is_int($value) && !is_float($value))) {
        throw new \Exception("Q13 array elements cannot be null and must be numeric");
      }
    }

    $totalStaticPoint = $this->staticPoints['Q13'] ?? 0;

    $totalWeighting = array_reduce(
      $resQ13,
      function ($acc, $cur) {
        if (!isset($this->weightings['Q13'][$cur])) {
          throw new \Exception("Invalid weighting value for Q13: {$cur}");
        }

        return $acc + ($this->weightings['Q13'][$cur] ?? 0);
      },
      0
    );

    $this->addTotalScore($totalStaticPoint * $totalWeighting);
  }
}
