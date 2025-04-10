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

    if ($resQ4 === null) {
      $this->addTotalScore(0);
      return;
    }
    if (!is_int($resQ4) && !is_float($resQ4)) {
      throw new Exception("設問Q4：選択された値が無効です");
    }
    if (!isset($this->weightings["Q4"][$resQ4])) {
      throw new Exception("設問Q4：正しい選択肢から選んでください");
    }

    $this->addTotalScore($this->staticPoints["Q4"] * $this->weightings["Q4"][$resQ4]);
  }

  public function calcQ11(): void
  {
    $resQ11 = $this->res["Q11"];

    if (!isset($resQ11)) {
      throw new \Exception("設問Q11：データが入力されていません");
    }
    if (empty($resQ11)) {
      $this->addTotalScore(0);
      return;
    }
    if (count($resQ11) > 4) {
      throw new Exception("設問Q11：選択は4つまでです");
    }
    foreach ($resQ11 as $value) {
      if ($value === null || (!is_int($value) && !is_float($value))) {
        throw new Exception("設問Q11：選択された値が無効です");
      }
    }

    $totalStaticScore = $this->staticPoints["Q11"] ?? 0;

    $totalWeighting = array_reduce(
      $resQ11,
      function ($acc, $cur) {
        if (!isset($this->weightings["Q11"][$cur])) {
          throw new Exception("設問Q11：正しい選択肢から選んで下さい");
        }
        return $acc + ($this->weightings["Q11"][$cur] ?? 0);
      },
      0
    );

    $this->addTotalScore($totalStaticScore * $totalWeighting);
  }
}
