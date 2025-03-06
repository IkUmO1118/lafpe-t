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

    if (isset($resQ3) && !empty($resQ3)) {
      $totalStaticPoint = $this->staticPoints['Q3'] ?? 0;
      $totalDynamicPoint = 0;

      $this->addTotalScore($totalStaticPoint);

      foreach ($resQ3 as $rackKey => $rackValue) {
        if (isset($rackValue['isChecked']) && $rackValue['isChecked']) {
          if (!isset($rackValue['times']) || !isset($rackValue['per'])) {
            throw new Exception("Required parameters 'times' and 'per' are missing for checked rack: " . $rackKey);
          }

          $times = $rackValue['times'];

          $totalDynamicPoint += $this->dynamicPoints['Q3'][$rackKey][$times];
        }
      }

      $this->addTotalScore($totalDynamicPoint);
    }
  }

  private function calcQ13(): void
  {
    $resQ13 = $this->res['Q13'];

    if (isset($resQ13) && !empty($resQ13)) {
      $totalStaticPoint = $this->staticPoints['Q13'] ?? 0;

      $totalWeighting = array_reduce(
        $resQ13,
        function ($acc, $cur) {
          return $acc + ($this->weightings['Q13'][$cur] ?? 0);
        },
        0
      );

      $this->addTotalScore($totalStaticPoint * $totalWeighting);
    }
  }
}
