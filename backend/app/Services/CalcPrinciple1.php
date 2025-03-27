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
    $requiredRacks = [
      'openRack',
      'IVCRack',
      'positiveRack',
      'negativeRack',
      'oneWayAirflowRack',
      'isolator'
    ];

    if (!isset($resQ3) || empty($resQ3)) {
      throw new \Exception("設問Q3のデータが入力されていません");
    }

    foreach ($requiredRacks as $rack) {
      if (!isset($resQ3[$rack])) {
        throw new Exception("設問3に必要なラック情報「{$rack}」が不足しています");
      }
    }

    $totalStaticPoint = $this->staticPoints['Q3'] ?? 0;
    $totalDynamicPoint = 0;

    $this->addTotalScore($totalStaticPoint);

    foreach ($resQ3 as $rackKey => $rackValue) {
      if (!isset($rackValue['isChecked'])) {
        throw new \Exception("ラック「{$rackKey}」の選択状態が設定されていません");
      }

      if ($rackValue['isChecked']) {
        if (!isset($rackValue['per']) || $rackValue['per'] === null || !is_numeric($rackValue['per'])) {
          throw new \Exception("選択されたラック「{$rackKey}」の使用割合（per）は数値で入力してください");
        }
        if (!isset($rackValue['times']) || $rackValue['times'] === null || !is_numeric($rackValue['times'])) {
          throw new \Exception("選択されたラック「{$rackKey}」の換気回数（times）は数値で入力してください");
        }

        $times = (int)$rackValue['times'];

        if (!isset($this->dynamicPoints['Q3'][$rackKey][$times])) {
          throw new Exception("ラック「{$rackKey}」の換気回数値「{$times}」が設定に存在しません");
        }

        $totalDynamicPoint += $this->dynamicPoints['Q3'][$rackKey][$times];
      }
    }

    $this->addTotalScore($totalDynamicPoint);
  }

  private function calcQ13(): void
  {
    $resQ13 = $this->res['Q13'];

    if (empty($resQ13)) {
      $this->addTotalScore(0);
      return;
    }
    if (count($resQ13) > 2) {
      throw new \Exception("設問Q13の選択は2つまでです");
    }
    foreach ($resQ13 as $value) {
      if ($value === null || (!is_int($value) && !is_float($value))) {
        throw new \Exception("設問Q13の選択値は数値である必要があります");
      }
    }

    $totalStaticPoint = $this->staticPoints['Q13'] ?? 0;

    $totalWeighting = array_reduce(
      $resQ13,
      function ($acc, $cur) {
        if (!isset($this->weightings['Q13'][$cur])) {
          throw new \Exception("設問Q13の選択値「{$cur}」は無効な値です");
        }

        return $acc + ($this->weightings['Q13'][$cur] ?? 0);
      },
      0
    );

    $this->addTotalScore($totalStaticPoint * $totalWeighting);
  }
}
