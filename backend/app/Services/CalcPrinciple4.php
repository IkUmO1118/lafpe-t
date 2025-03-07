<?php

namespace App\Services;

use App\Services\Contracts\AbstractPrinciple;
use Exception;

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
    }
  }

  private function calcQ3(): void
  {
    $resQ3 = $this->res['Q3'];
    $requiredRacks = [
      'openRack',
      'IVCRack',
      'positiveRack',
      'negativeRack',
      'oneWayAirflowRack',
      'isolator'
    ];

    if (!isset($resQ3) || empty($resQ3)) {
      throw new Exception("Empty data for Q3");
    }

    foreach ($requiredRacks as $rack) {
      if (!isset($resQ3[$rack])) {
        throw new \Exception("Missing required racks in Q3");
      }
    }

    $totalStaticPoint = $this->staticPoints['Q3'] ?? 0;
    $totalWeighting = 0;

    $hasChecked = false;

    foreach ($resQ3 as $rackKey => $rackValue) {
      if ($rackValue['isChecked'] === null) {
        throw new Exception('isChecked value cannot be null');
      }

      if (isset($rackValue['isChecked']) && $rackValue['isChecked']) {
        $hasChecked = true;

        if (!isset($rackValue['per']) || $rackValue['per'] === null || (!is_int($rackValue['per']) && !is_float($rackValue['per']))) {
          throw new Exception("Per value cannot be null and numeric for checked rack");
        }
        if (!isset($rackValue['times']) || $rackValue['times'] === null || (!is_int($rackValue['times']) && !is_float($rackValue['times']))) {
          throw new Exception("Times value cannot be null and numeric for checked rack");
        }

        $per = $rackValue['per'];
        $times = $rackValue['times'];

        if (!isset($this->weightings['Q3'][$rackKey]['perWeighting'][$per]) || !isset($this->weightings['Q3'][$rackKey]['timesWeighting'][$times])) {
          throw new Exception("Invalid value for rack {$rackKey}: times and per not found in configuration");
        }

        $rackWeight  = $this->weightings['Q3'][$rackKey]['rackWeighting'] ?? 0;
        $perWeight   = $this->weightings['Q3'][$rackKey]['perWeighting'][$per] ?? 0;
        $timesWeight = $this->weightings['Q3'][$rackKey]['timesWeighting'][$times] ?? 0;

        $totalWeighting += $rackWeight * $perWeight * $timesWeight;
      }
    }

    if (!$hasChecked) {
      throw new Exception("At least one rack must be checked for Q3");
    }

    $this->addTotalScore($totalWeighting * $totalStaticPoint);
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
    }
  }
}
