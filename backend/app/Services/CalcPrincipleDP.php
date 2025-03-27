<?php

namespace App\Services;

use App\Services\Contracts\AbstractPrinciple;
use Exception;

class CalcPrincipleDP extends AbstractPrinciple
{
  protected static ?string $principle = "principleDP";
  protected static array $questionList = ['Q4', 'Q11'];

  public function calculate(): float
  {
    $this->calcQ4();
    $this->calcQ11();

    return $this->getTotalScore();
  }

  public function calcQ4(): void
  {
    $resQ4 = $this->res['Q4'];

    if (!isset($resQ4)) {
      throw new Exception("設問Q4の回答が入力されていません");
    }
    if ($resQ4 === null) {
      $this->addTotalScore(0);
      return;
    }
    if (!is_int($resQ4) && !is_float($resQ4)) {
      throw new Exception("設問Q4の回答は数値である必要があります");
    }
    if (!isset($this->weightings["Q4"][$resQ4])) {
      throw new Exception("設問Q4の選択値「{$resQ4}」は無効な値です");
    }

    $this->addTotalScore($this->staticPoints["Q4"] * $this->weightings["Q4"][$resQ4]);
  }

  public function calcQ11(): void
  {
    $resQ11 = $this->res["Q11"];

    if (!isset($resQ11)) {
      throw new \Exception("設問Q11のデータが入力されていません");
    }
    if (empty($resQ11)) {
      $this->addTotalScore(0);
      return;
    }
    if (count($resQ11) > 4) {
      throw new Exception("設問Q11の選択は4つまでです");
    }
    foreach ($resQ11 as $value) {
      if ($value === null || (!is_int($value) && !is_float($value))) {
        throw new Exception("設問Q11の選択値は数値である必要があります");
      }
    }

    $totalStaticScore = $this->staticPoints["Q11"] ?? 0;

    $totalWeighting = array_reduce(
      $resQ11,
      function ($acc, $cur) {
        if (!isset($this->weightings["Q11"][$cur])) {
          throw new Exception("設問Q11の選択値「{$cur}」は無効な値です");
        }
        return $acc + ($this->weightings["Q11"][$cur] ?? 0);
      },
      0
    );

    $this->addTotalScore($totalStaticScore * $totalWeighting);
  }
}
