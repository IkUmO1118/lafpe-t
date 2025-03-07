<?php

namespace App\Services;

use App\Services\Contracts\AbstractPrinciple;
use Exception;

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
  private function calcQ12(): void
  {
    $res12 = $this->res["Q12"];

    if (!isset($res12) || empty($res12)) {
      throw new Exception("Empty data for Q12");
    }
    if (count($res12) > 15) {
      throw new Exception("Too many values for Q12");
    }

    foreach ($res12 as $value) {
      if ($value === null || (!is_int($value) && !is_float($value))) {
        throw new Exception("Q12 array elementes cannot be null and must be numeric");
      }
    }

    $scoreMap = [0, 1, 3, 4, 6];

    $this->addTotalScore($scoreMap[min(count($res12), 4)]);
  }
}
