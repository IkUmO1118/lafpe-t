<?php

namespace app\Services;

interface Principle
{
  public function calculate(array $res): float;
}
