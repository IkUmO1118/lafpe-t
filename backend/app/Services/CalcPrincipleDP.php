<?php

namespace app\Services;

use app\Services\Contracts\AbstractPrinciple;

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

    if ($resQ4 === 0 || $resQ4) {
      $this->addTotalScore($this->staticPoints["Q4"] * $this->weightings["Q4"][$resQ4]);
    }

    echo "Principle DP" . PHP_EOL . 'Q4: ' . $this->staticPoints["Q4"] * $this->weightings["Q4"][$resQ4] . PHP_EOL;
  }

  public function calcQ11(): void
  {
    $resQ11 = $this->res["Q11"];

    if (isset($resQ11) && !empty($resQ11)) {
      $totalStaticScore = $this->staticPoints["Q11"] ?? 0;

      $totalWeighting = array_reduce(
        $resQ11,
        function ($acc, $cur) {
          return $acc + ($this->weightings["Q11"][$cur] ?? 0);
        },
        0
      );

      $this->addTotalScore($totalStaticScore * $totalWeighting);
      echo 'Q11: ' . $totalStaticScore * $totalWeighting . PHP_EOL;
    }
  }
}
