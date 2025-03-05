<?php

namespace App\Services\Contracts;

interface Principle
{
  public static function getPrinciple(): string;
  public function getTotalScore(): float;
  public function addTotalScore(float $score): void;
  public function calculate(): float;
}
