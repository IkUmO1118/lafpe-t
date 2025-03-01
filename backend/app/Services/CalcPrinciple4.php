<?php

namespace app\Services;

use app\Services\Contracts\AbstractPrinciple;

class CalcPrinciple4 extends AbstractPrinciple
{
  protected static ?string $principle = "principle4";
  protected static array $questionList = ['Q1', 'Q2', 'Q3', 'Q4', 'Q5', 'Q6', 'Q7', 'Q10'];

  public function calculate(): float
  {
    $this->calcQ1();
    $this->calcQ2();
    $this->calcQ3();
    $this->calcQ4();
    $this->calcQ5();
    $this->calcQ6();
    $this->calcQ7();
    $this->calcQ10();

    return $this->getTotalScore();
  }

  private function calcQ1(): void
  {
    $resQ1 = $this->res['Q1'];

    if (isset($resQ1) && !empty($resQ1)) {
      $totalStaticScore = $this->staticPoints["Q1"] ?? 0;

      $totalWeighting = array_reduce(
        $resQ1,
        function ($acc, $cur) {
          return $acc + ($this->weightings["Q1"][$cur] ?? 0);
        },
        0
      );

      $this->addTotalScore($totalStaticScore * $totalWeighting);
      echo "Principle 4" . PHP_EOL . 'Q1: ' . $totalStaticScore * $totalWeighting . PHP_EOL;
    }
  }

  private function calcQ2(): void
  {
    $resQ2 = $this->res['Q2'];

    if (isset($resQ2) && !empty($resQ2)) {
      $totalStaticScore = $this->staticPoints["Q2"] ?? 0;

      $totalWeighting = array_reduce(
        $resQ2,
        function ($acc, $cur) {
          return $acc + ($this->weightings["Q2"][$cur] ?? 0);
        },
        0
      );

      $this->addTotalScore($totalStaticScore * $totalWeighting);
      echo 'Q2: ' . $totalStaticScore * $totalWeighting . PHP_EOL;
    }
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

    echo 'Q3: ' . $totalWeighting * $this->staticPoints['Q3'] . PHP_EOL;
  }
  private function calcQ4(): void
  {
    $resQ4 = $this->res['Q4'];

    if ($resQ4 === 0 || $resQ4) {
      $this->addTotalScore($this->staticPoints["Q4"] * $this->weightings["Q4"][$resQ4]);
    }

    echo 'Q4: ' . $this->staticPoints["Q4"] * $this->weightings["Q4"][$resQ4] . PHP_EOL;
  }

  private function calcQ5(): void
  {
    $resQ5 = $this->res['Q5'];

    if ($resQ5 === 0 || $resQ5) {
      $this->addTotalScore($this->staticPoints["Q5"] * $this->weightings["Q5"][$resQ5]);
    }

    echo 'Q5: ' . $this->staticPoints["Q5"] * $this->weightings["Q5"][$resQ5] . PHP_EOL;
  }

  private function calcQ6(): void
  {
    $resQ6 = $this->res['Q6'];

    if ($resQ6 === 0 || $resQ6) {
      $this->addTotalScore($this->staticPoints["Q6"] * $this->weightings["Q6"][$resQ6]);
    }

    echo 'Q6: ' . $this->staticPoints["Q6"] * $this->weightings["Q6"][$resQ6] . PHP_EOL;
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
      echo 'Q7: ' . $totalStaticScore * $totalWeighting . PHP_EOL;
    }
  }

  private function calcQ10(): void
  {
    $resQ10 = $this->res['Q10'];

    if (isset($resQ10) && !empty($resQ10)) {
      $totalStaticScore = $this->staticPoints["Q10"] ?? 0;

      $totalWeighting = array_reduce(
        $resQ10,
        function ($acc, $cur) {
          return $acc + ($this->weightings["Q10"][$cur] ?? 0);
        },
        0
      );

      $this->addTotalScore($totalStaticScore * $totalWeighting);
      echo 'Q10: ' . $totalStaticScore * $totalWeighting . PHP_EOL;
    }
  }
}
