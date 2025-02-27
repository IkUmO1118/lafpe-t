<?php

namespace app\Services;

interface Principle
{
  public static function getPrinciple(): string;
  public function getTotalScore(): float;
  public function calculate(array $res): float;
}
