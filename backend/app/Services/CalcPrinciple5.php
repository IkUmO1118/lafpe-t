<?php

namespace app\Services;

use app\Services\Contracts\AbstractPrinciple;

class CalcPrinciple5 extends AbstractPrinciple
{
  protected static ?string $principle = "principle5";
  protected static array $questionList = ["Q3", "Q12"];

  public function calculate(): float
  {
    $this->calcQ3();
    $this->calcQ12();

    return $this->getTotalScore();
  }

  private function calcQ3(): void
  {
    $resQ3 = $this->res['Q3'];

    if (isset($resQ3) && !empty($resQ3)) {
      $totalStaticPoint = $this->staticPoints['Q3'] ?? 0;
      $totalWeighting = 0;

      foreach ($resQ3 as $rackKey => $rackValue) {
        if (isset($rackValue['isChecked']) && $rackValue['isChecked']) {

          $rackWeight  = $this->weightings['Q3'][$rackKey]['rackWeighting'] ?? 0;
          $perWeight   = $this->weightings['Q3'][$rackKey]['perWeighting'][$rackValue['per']] ?? 0;
          $timesWeight = $this->weightings['Q3'][$rackKey]['timesWeighting'][$rackValue['times']] ?? 0;

          $totalWeighting += $rackWeight * $perWeight * $timesWeight;
        }
      }

      $this->addTotalScore($totalWeighting * $totalStaticPoint);
    }
  }
  private function calcQ12(): void
  {
    $res12 = $this->res["Q12"];

    if (isset($res12) && !empty($res12)) {
      $scoreMap = [0, 1, 3, 4, 6];

      $this->addTotalScore($scoreMap[min(count($res12), 4)]);
    }
  }
}
