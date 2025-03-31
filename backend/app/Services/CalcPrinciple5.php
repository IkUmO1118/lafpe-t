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
    error_log("start Q3");
    $this->calcQ3();
    error_log($this->getTotalScore());
    error_log("end Q3");
    error_log("start Q12");
    $this->calcQ12();
    error_log($this->getTotalScore());
    error_log("end Q12");

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

    foreach ($resQ3 as $rackKey => $rackValue) {
      if (!isset($rackValue['isChecked'])) {
        throw new \Exception("ラック「{$rackKey}」の選択状態が設定されていません");
      }

      if ($rackValue['isChecked']) {

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

    error_log("Q3: " . $totalWeighting * $totalStaticPoint);
    $this->addTotalScore($totalWeighting * $totalStaticPoint);
  }

  private function calcQ12(): void
  {
    $resQ12 = $this->res["Q12"];

    if (empty($resQ12)) {
      $this->addTotalScore(0);
      return;
    }
    if (count($resQ12) > 15) {
      throw new Exception("設問Q12の選択は15個までです");
    }

    $validValues = [];
    foreach ($resQ12 as $value) {
      if ($value === null || (!is_int($value) && !is_float($value))) {
        throw new Exception("設問Q12の選択値は数値である必要があります");
      }

      if ($value < 0 || $value > 14) {
        throw new Exception("設問Q12の選択値は0から14までの値である必要があります");
      }

      $validValues[intval($value)] = true;
    }

    $uniqueValues = array_keys($validValues);

    $scoreMap = [0, 0.5, 1.5, 2, 3];

    error_log("Q12: " . $scoreMap[min(count($uniqueValues), 4)] + 5);
    $this->addTotalScore($scoreMap[min(count($uniqueValues), 4)] + 5);
  }
}
