<?php

use app\Services\Contracts\AbstractPrinciple;

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
  }
  private function calcQ2(): void
  {
    $resQ1 = $this->res['Q2'];
  }
  private function calcQ3(): void
  {
    $resQ1 = $this->res['Q3'];
  }
  private function calcQ5(): void
  {
    $resQ1 = $this->res['Q5'];
  }
  private function calcQ6(): void
  {
    $resQ1 = $this->res['Q6'];
  }
  private function calcQ7(): void
  {
    $resQ1 = $this->res['Q7'];
  }
  private function calcQ8(): void
  {
    $resQ1 = $this->res['Q8'];
  }
}
