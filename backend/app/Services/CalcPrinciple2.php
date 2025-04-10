<?php

namespace App\Services;

use App\Services\Contracts\AbstractPrinciple;
use Exception;

class CalcPrinciple2 extends AbstractPrinciple
{
  protected static ?string $principle = "principle2";
  protected static array $questionList = ["Q1", "Q2", "Q3", "Q5", "Q6", "Q7", "Q8"];

  public function calculate(): float
  {
    $this->calcQ1();
    $this->calcQ2();
    $this->calcQ3();
    $this->calcQ5();
    $this->calcQ6();
    $this->calcQ7();
    $this->calcQ8();

    return $this->getTotalScore();
  }

  private function calcQ1(): void
  {
    $resQ1 = $this->res['Q1'];

    if (empty($resQ1)) {
      $this->addTotalScore(0);
      return;
    }
    if (count($resQ1) > 2) {
      throw new \Exception("設問Q1：選択は2つまでです");
    }
    foreach ($resQ1 as $value) {
      if ($value === null || (!is_int($value) && !is_float($value))) {
        throw new \Exception("設問Q1：選択された値が無効です");
      }
    }

    $totalStaticPoint = $this->staticPoints['Q1'] ?? 0;

    $totalWeighting = array_reduce(
      $resQ1,
      function ($acc, $cur) {
        if (!isset($this->weightings['Q1'][$cur])) {
          throw new \Exception("設問Q1：正しい選択肢から選んでください");
        }

        return $acc + ($this->weightings['Q1'][$cur] ?? 0);
      },
      0
    );

    $this->addTotalScore($totalStaticPoint * $totalWeighting);
  }

  private function calcQ2(): void
  {
    $resQ2 = $this->res['Q2'];

    if (empty($resQ2)) {
      $this->addTotalScore(0);
      return;
    }
    if (count($resQ2) > 2) {
      throw new \Exception("設問Q2：選択は2つまでです");
    }
    foreach ($resQ2 as $value) {
      if ($value === null || (!is_int($value) && !is_float($value))) {
        throw new \Exception("設問Q2：選択された値が無効です");
      }
    }

    $totalStaticPoint = $this->staticPoints['Q2'] ?? 0;

    $totalWeighting = array_reduce(
      $resQ2,
      function ($acc, $cur) {
        if (!isset($this->weightings['Q2'][$cur])) {
          throw new \Exception("設問Q2：正しい選択肢から選んでください");
        }

        return $acc + ($this->weightings['Q2'][$cur] ?? 0);
      },
      0
    );

    $this->addTotalScore($totalStaticPoint * $totalWeighting);
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
      throw new Exception("設問Q3：データが入力されていません");
    }

    foreach ($requiredRacks as $rack) {
      if (!isset($resQ3[$rack])) {
        throw new \Exception("設問3：必要なラック情報「{$rack}」が不足しています");
      }
    }

    $totalStaticPoint = $this->staticPoints['Q3'] ?? 0;
    $totalWeighting = 0;

    foreach ($resQ3 as $rackKey => $rackValue) {
      if (!isset($rackValue['isChecked'])) {
        throw new \Exception("設問3：ラック「{$rackKey}」の選択状態が設定されていません");
      }

      if ($rackValue['isChecked']) {

        if (!isset($rackValue['per']) || $rackValue['per'] === null || (!is_int($rackValue['per']) && !is_float($rackValue['per']))) {
          throw new Exception("設問3：選択されたラック「{$rackKey}」の使用割合を入力してください");
        }
        if (!isset($rackValue['times']) || $rackValue['times'] === null || (!is_int($rackValue['times']) && !is_float($rackValue['times']))) {
          throw new Exception("設問3：選択されたラック「{$rackKey}」の換気回数を入力してください");
        }

        $per = $rackValue['per'];
        $times = $rackValue['times'];

        if (!isset($this->weightings['Q3'][$rackKey]['perWeighting'][$per]) || !isset($this->weightings['Q3'][$rackKey]['timesWeighting'][$times])) {
          throw new Exception("設問3：ラック「{$rackKey}」の換気回数または使用割合が設定に存在しません");
        }

        $rackWeight  = $this->weightings['Q3'][$rackKey]['rackWeighting'] ?? 0;
        $perWeight   = $this->weightings['Q3'][$rackKey]['perWeighting'][$per] ?? 0;
        $timesWeight = $this->weightings['Q3'][$rackKey]['timesWeighting'][$times] ?? 0;

        $totalWeighting += $rackWeight * $perWeight * $timesWeight;
      }
    }

    $this->addTotalScore($totalWeighting * $totalStaticPoint);
  }

  public function calcQ5(): void
  {
    $resQ5 = $this->res['Q5'];

    if ($resQ5 === null) {
      $this->addTotalScore(0);
      return;
    }
    if (!is_int($resQ5) && !is_float($resQ5)) {
      throw new Exception("設問Q5：選択された値が無効です");
    }
    if (!isset($this->weightings["Q5"][$resQ5])) {
      throw new Exception("設問Q5：正しい選択肢から選んでください");
    }

    $this->addTotalScore($this->staticPoints["Q5"] * $this->weightings["Q5"][$resQ5]);
  }

  public function calcQ6(): void
  {
    $resQ6 = $this->res['Q6'];

    if ($resQ6 === null) {
      $this->addTotalScore(0);
      return;
    }
    if (!is_int($resQ6) && !is_float($resQ6)) {
      throw new Exception("設問Q6：選択された値が無効です");
    }

    if (!isset($this->weightings["Q6"][$resQ6])) {
      throw new Exception("設問Q6：正しい選択肢から選んでください");
    }

    $this->addTotalScore($this->staticPoints["Q6"] * $this->weightings["Q6"][$resQ6]);
  }

  private function calcQ7(): void
  {
    $resQ7 = $this->res['Q7'];

    if (empty($resQ7)) {
      $this->addTotalScore(0);
      return;
    }
    if (count($resQ7) > 2) {
      throw new \Exception("設問Q7：選択は2つまでです");
    }
    foreach ($resQ7 as $value) {
      if ($value === null || (!is_int($value) && !is_float($value))) {
        throw new \Exception("設問Q7：選択された値が無効です");
      }
    }

    $totalStaticPoint = $this->staticPoints['Q7'] ?? 0;

    // 最大値を0で初期化
    $maxWeighting = 0;

    // 各選択値の重み付けをループし、最大値を見つける
    foreach ($resQ7 as $cur) {
      if (!isset($this->weightings['Q7'][$cur])) {
        throw new \Exception("設問Q7：正しい選択肢から選んで下さい");
      }

      $currentWeighting = $this->weightings['Q7'][$cur] ?? 0;
      if ($currentWeighting > $maxWeighting) {
        $maxWeighting = $currentWeighting;
      }
    }

    // 最大値を使ってスコアを計算
    $this->addTotalScore($totalStaticPoint * $maxWeighting);
  }

  private function calcQ8(): void
  {
    $resQ8 = $this->res['Q8'];

    if (empty($resQ8)) {
      $this->addTotalScore(0);
      return;
    }
    if (count($resQ8) > 4) {
      throw new \Exception("設問Q8：選択は4つまでです");
    }
    foreach ($resQ8 as $value) {
      if ($value === null || (!is_int($value) && !is_float($value))) {
        throw new \Exception("設問Q8：選択された値が無効です");
      }
    }

    $totalStaticPoint = $this->staticPoints['Q8'] ?? 0;

    $totalWeighting = array_reduce(
      $resQ8,
      function ($acc, $cur) {
        if (!isset($this->weightings['Q8'][$cur])) {
          throw new \Exception("設問Q8：正しい選択肢から選んで下さい");
        }

        return $acc + ($this->weightings['Q8'][$cur] ?? 0);
      },
      0
    );

    $this->addTotalScore($totalStaticPoint * $totalWeighting);
  }
}
