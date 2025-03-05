<?php

namespace App\Services;

use App\Services\Contracts\AbstractPrinciple;

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
          $times = $rackValue['times'] ?? 0;

          $totalDynamicPoint += $this->dynamicPoints['Q3'][$rackKey][$times] ?? 0;
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
