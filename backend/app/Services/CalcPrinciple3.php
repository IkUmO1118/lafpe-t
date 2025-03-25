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
      throw new Exception("設問Q3のデータが入力されていません");
    }

    foreach ($requiredRacks as $rack) {
      if (!isset($resQ3[$rack])) {
        throw new \Exception("設問3に必要なラック情報「{$rack}」が不足しています");
      }
    }

    $totalStaticPoint = $this->staticPoints['Q3'] ?? 0;
    $totalWeighting = 0;

    $hasChecked = false;

    foreach ($resQ3 as $rackKey => $rackValue) {
      if ($rackValue['isChecked'] === null || !is_bool($rackValue['isChecked'])) {
        throw new Exception("ラック「{$rackKey}」の選択状態が設定されていません");
      }

      if (isset($rackValue['isChecked']) && $rackValue['isChecked']) {
        $hasChecked = true;

        if (!isset($rackValue['per']) || $rackValue['per'] === null || (!is_int($rackValue['per']) && !is_float($rackValue['per']))) {
          throw new Exception("選択されたラック「{$rackKey}」の使用割合（per）は数値で入力してください");
        }
        if (!isset($rackValue['times']) || $rackValue['times'] === null || (!is_int($rackValue['times']) && !is_float($rackValue['times']))) {
          throw new Exception("選択されたラック「{$rackKey}」の換気回数（times）は数値で入力してください");
        }

        $per = $rackValue['per'];
        $times = $rackValue['times'];

        if (!isset($this->weightings['Q3'][$rackKey]['perWeighting'][$per]) || !isset($this->weightings['Q3'][$rackKey]['timesWeighting'][$times])) {
          throw new Exception("ラック「{$rackKey}」の換気回数値「{$times}」または使用割合「{$per}」が設定に存在しません");
        }

        $rackWeight  = $this->weightings['Q3'][$rackKey]['rackWeighting'] ?? 0;
        $perWeight   = $this->weightings['Q3'][$rackKey]['perWeighting'][$per] ?? 0;
        $timesWeight = $this->weightings['Q3'][$rackKey]['timesWeighting'][$times] ?? 0;

        $totalWeighting += $rackWeight * $perWeight * $timesWeight;
      }
    }

    if (!$hasChecked) {
      throw new Exception("設問Q3では少なくとも1つのラックを選択してください");
    }

    $this->addTotalScore($totalWeighting * $totalStaticPoint);
  }

  public function calcQ4(): void
  {
    $resQ4 = $this->res['Q4'];

    if (!isset($resQ4) || $resQ4 === null) {
      throw new Exception("設問Q4の回答が入力されていません");
    }

    if (!is_int($resQ4) && !is_float($resQ4)) {
      throw new Exception("設問Q4の回答は数値である必要があります");
    }

    if (!isset($this->weightings["Q4"][$resQ4])) {
      throw new Exception("設問Q4の選択値「{$resQ4}」は無効な値です");
    }

    $this->addTotalScore($this->staticPoints["Q4"] * $this->weightings["Q4"][$resQ4]);
  }

  public function calcQ5(): void
  {
    $resQ5 = $this->res['Q5'];

    if (!isset($resQ5) || $resQ5 === null) {
      throw new Exception("設問Q5の回答が入力されていません");
    }

    if (!is_int($resQ5) && !is_float($resQ5)) {
      throw new Exception("設問Q5の回答は数値である必要があります");
    }

    if (!isset($this->weightings["Q5"][$resQ5])) {
      throw new Exception("設問Q5の選択値「{$resQ5}」は無効な値です");
    }

    $this->addTotalScore($this->staticPoints["Q5"] * $this->weightings["Q5"][$resQ5]);
  }

  public function calcQ6(): void
  {
    $resQ6 = $this->res['Q6'];

    if (!isset($resQ6) || $resQ6 === null) {
      throw new Exception("設問Q6の回答が入力されていません");
    }

    if (!is_int($resQ6) && !is_float($resQ6)) {
      throw new Exception("設問Q6の回答は数値である必要があります");
    }

    if (!isset($this->weightings["Q6"][$resQ6])) {
      throw new Exception("設問Q6の選択値「{$resQ6}」は無効な値です");
    }

    $this->addTotalScore($this->staticPoints["Q6"] * $this->weightings["Q6"][$resQ6]);
  }

  private function calcQ7(): void
  {
    $resQ7 = $this->res['Q7'];

    if (!isset($resQ7) || empty($resQ7)) {
      throw new \Exception("設問Q7のデータが入力されていません");
    }
    if (count($resQ7) > 2) {
      throw new \Exception("設問Q7の選択は2つまでです");
    }
    foreach ($resQ7 as $value) {
      if ($value === null || (!is_int($value) && !is_float($value))) {
        throw new \Exception("設問Q7の選択値は数値である必要があります");
      }
    }

    $totalStaticPoint = $this->staticPoints['Q7'] ?? 0;

    $totalWeighting = array_reduce(
      $resQ7,
      function ($acc, $cur) {
        if (!isset($this->weightings['Q7'][$cur])) {
          throw new \Exception("設問Q7の選択値「{$cur}」は無効な値です");
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
      throw new \Exception("設問Q8のデータが入力されていません");
    }
    if (count($resQ8) > 4) {
      throw new \Exception("設問Q8の選択は4つまでです");
    }
    foreach ($resQ8 as $value) {
      if ($value === null || (!is_int($value) && !is_float($value))) {
        throw new \Exception("設問Q8の選択値は数値である必要があります");
      }
    }

    $totalStaticPoint = $this->staticPoints['Q8'] ?? 0;

    $totalWeighting = array_reduce(
      $resQ8,
      function ($acc, $cur) {
        if (!isset($this->weightings['Q8'][$cur])) {
          throw new \Exception("設問Q8の選択値「{$cur}」は無効な値です");
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
      throw new \Exception("設問Q9のデータが入力されていません");
    }
    if (count($resQ9) > 4) {
      throw new \Exception("設問Q9の選択は4つまでです");
    }
    foreach ($resQ9 as $value) {
      if ($value === null || (!is_int($value) && !is_float($value))) {
        throw new \Exception("設問Q9の選択値は数値である必要があります");
      }
    }

    $totalStaticPoint = $this->staticPoints['Q9'] ?? 0;

    $totalWeighting = array_reduce(
      $resQ9,
      function ($acc, $cur) {
        if (!isset($this->weightings['Q9'][$cur])) {
          throw new \Exception("設問Q9の選択値「{$cur}」は無効な値です");
        }

        return $acc + ($this->weightings['Q9'][$cur] ?? 0);
      },
      0
    );

    $this->addTotalScore($totalStaticPoint * $totalWeighting);
  }
}
