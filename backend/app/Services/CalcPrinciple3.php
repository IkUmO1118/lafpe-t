<?php

namespace App\Services;

use App\Services\Contracts\AbstractPrinciple;
use Exception;

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
      if ($rackValue['isChecked'] === null || !is_bool($rackValue['isChecked'])) {
        throw new Exception('isChecked value cannot be null and must be boolean');
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

  public function calcQ5(): void
  {
    $resQ5 = $this->res['Q5'];

    if (!isset($resQ5) || $resQ5 === null) {
      throw new Exception("Q5 value cannot be null");
    }

    if (!is_int($resQ5) && !is_float($resQ5)) {
      throw new Exception("Q5 value must be numeric");
    }

    if (!isset($this->weightings["Q5"][$resQ5])) {
      throw new Exception("Invalid weighting value for Q5: {$resQ5}");
    }

    $this->addTotalScore($this->staticPoints["Q5"] * $this->weightings["Q5"][$resQ5]);
  }

  public function calcQ6(): void
  {
    $resQ6 = $this->res['Q6'];

    if (!isset($resQ6) || $resQ6 === null) {
      throw new Exception("Q6 value cannot be null");
    }

    if (!is_int($resQ6) && !is_float($resQ6)) {
      throw new Exception("Q6 value must be numeric");
    }

    if (!isset($this->weightings["Q6"][$resQ6])) {
      throw new Exception("Invalid weighting value for Q6: {$resQ6}");
    }

    $this->addTotalScore($this->staticPoints["Q6"] * $this->weightings["Q6"][$resQ6]);
  }

  private function calcQ7(): void
  {
    $resQ7 = $this->res['Q7'];

    if (!isset($resQ7) || empty($resQ7)) {
      throw new \Exception("Empty data for Q7");
    }
    if (count($resQ7) > 2) {
      throw new \Exception("Too many values for Q7");
    }
    foreach ($resQ7 as $value) {
      if ($value === null || (!is_int($value) && !is_float($value))) {
        throw new \Exception("Q7 array elements cannot be null and must be numeric");
      }
    }

    $totalStaticPoint = $this->staticPoints['Q7'] ?? 0;

    $totalWeighting = array_reduce(
      $resQ7,
      function ($acc, $cur) {
        if (!isset($this->weightings['Q7'][$cur])) {
          throw new \Exception("Invalid weighting value for Q7: {$cur}");
        }

        return $acc + ($this->weightings['Q7'][$cur] ?? 0);
      },
      0
    );

    $this->addTotalScore($totalStaticPoint * $totalWeighting);
  }

  private function calcQ8(): void
  {
    $resQ8 = $this->res['Q8'];

    if (!isset($resQ8) || empty($resQ8)) {
      throw new \Exception("Empty data for Q8");
    }
    if (count($resQ8) > 4) {
      throw new \Exception("Too many values for Q8");
    }
    foreach ($resQ8 as $value) {
      if ($value === null || (!is_int($value) && !is_float($value))) {
        throw new \Exception("Q8 array elements cannot be null and must be numeric");
      }
    }

    $totalStaticPoint = $this->staticPoints['Q8'] ?? 0;

    $totalWeighting = array_reduce(
      $resQ8,
      function ($acc, $cur) {
        if (!isset($this->weightings['Q8'][$cur])) {
          throw new \Exception("Invalid weighting value for Q8: {$cur}");
        }

        return $acc + ($this->weightings['Q8'][$cur] ?? 0);
      },
      0
    );

    $this->addTotalScore($totalStaticPoint * $totalWeighting);
  }

  private function calcQ9(): void
  {
    $resQ9 = $this->res['Q9'];

    if (!isset($resQ9) || empty($resQ9)) {
      throw new \Exception("Empty data for Q9");
    }
    if (count($resQ9) > 4) {
      throw new \Exception("Too many values for Q9");
    }
    foreach ($resQ9 as $value) {
      if ($value === null || (!is_int($value) && !is_float($value))) {
        throw new \Exception("Q9 array elements cannot be null and must be numeric");
      }
    }

    $totalStaticPoint = $this->staticPoints['Q9'] ?? 0;

    $totalWeighting = array_reduce(
      $resQ9,
      function ($acc, $cur) {
        if (!isset($this->weightings['Q9'][$cur])) {
          throw new \Exception("Invalid weighting value for Q9: {$cur}");
        }

        return $acc + ($this->weightings['Q9'][$cur] ?? 0);
      },
      0
    );

    $this->addTotalScore($totalStaticPoint * $totalWeighting);
  }
}
