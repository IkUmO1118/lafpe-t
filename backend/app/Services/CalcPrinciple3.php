<?php

namespace App\Services;

use App\Services\Contracts\AbstractPrinciple;

class CalcPrinciple3 extends AbstractPrinciple
{
  protected static ?string $principle = "principle3";
  protected static array $questionList = ["Q3", "Q4", 'Q5', 'Q6', 'Q7', 'Q8', "Q9"];

  public function calculate(): float
  {
    $this->calcQ3();
    $this->calcQ4();
    $this->calcQ5();
    $this->calcQ6();
    $this->calcQ7();
    $this->calcQ8();
    $this->calcQ9();

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

  private function calcQ4(): void
  {
    $resQ4 = $this->res['Q4'];

    if ($resQ4 === 0 || $resQ4) {
      $this->addTotalScore($this->staticPoints["Q4"] * $this->weightings["Q4"][$resQ4]);
    }
  }

  private function calcQ5(): void
  {
    $resQ5 = $this->res['Q5'];

    if ($resQ5 === 0 || $resQ5) {
      $this->addTotalScore($this->staticPoints["Q5"] * $this->weightings["Q5"][$resQ5]);
    }
  }

  private function calcQ6(): void
  {
    $resQ6 = $this->res['Q6'];

    if ($resQ6 === 0 || $resQ6) {
      $this->addTotalScore($this->staticPoints["Q6"] * $this->weightings["Q6"][$resQ6]);
    }
  }

  private function calcQ7(): void
  {
    $resQ7 = $this->res['Q7'];

    if (isset($resQ7) && !empty($resQ7)) {
      $totalStaticScore = $this->staticPoints["Q7"] ?? 0;

      $totalWeighting = array_reduce(
        $resQ7,
        function ($acc, $cur) {
          return $acc + ($this->weightings["Q7"][$cur] ?? 0);
        },
        0
      );

      $this->addTotalScore($totalStaticScore * $totalWeighting);
    }
  }

  private function calcQ8(): void
  {
    $resQ8 = $this->res['Q8'];

    if (isset($resQ8) && !empty($resQ8)) {
      $totalStaticScore = $this->staticPoints["Q8"] ?? 0;

      $totalWeighting = array_reduce(
        $resQ8,
        function ($acc, $cur) {
          return $acc + ($this->weightings["Q8"][$cur] ?? 0);
        },
        0
      );

      $this->addTotalScore($totalStaticScore * $totalWeighting);
    }
  }

  private function calcQ9(): void
  {
    $resQ9 = $this->res['Q9'];

    if (isset($resQ9) && !empty($resQ9)) {
      $totalStaticScore = $this->staticPoints["Q9"] ?? 0;

      $totalWeighting = array_reduce(
        $resQ9,
        function ($acc, $cur) {
          return $acc + ($this->weightings["Q9"][$cur] ?? 0);
        },
        0
      );

      $this->addTotalScore($totalStaticScore * $totalWeighting);
    }
  }
}
