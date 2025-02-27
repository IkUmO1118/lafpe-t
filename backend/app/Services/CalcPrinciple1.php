<?php

namespace app\Services;

use app\Services\Contracts\AbstractPrinciple;

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

    if (isset($resQ3) && !empty($resQ3)) {
      $totalStaticPoint = $this->staticPoints['Q3'] ?? 0;
      $this->addTotalScore($totalStaticPoint);

      // 各項目のisCheckedを確認し、trueの場合は対応するポイントを加算
      foreach ($resQ3 as $key => $value) {
        if (isset($value['isChecked']) && $value['isChecked']) {
          $times = $value['times'] ?? 0;
          $dynamicPoint = $this->dynamicPoints['Q3'][$key][$times] ?? 0;
          $this->addTotalScore($dynamicPoint);
        }
      }
    }
  }

  private function calcQ13(): void
  {
    $resQ13 = $this->res['Q13'];

    if (isset($resQ13) && !empty($resQ13)) {
      $totalStaticPoint = $this->staticPoints['Q13'] ?? 0;

      $totalWeighting = array_reduce(
        $resQ13,
        function ($acc, $cur) {
          return $acc + ($this->weightings['Q13'][$cur] ?? 0);
        },
        0
      );

      $this->addTotalScore($totalStaticPoint * $totalWeighting);
    }
  }
}
