<?php

namespace App\Services\Contracts;

use App\Services\Contracts\Principle;
use Config\PrincipleConfig;
use Exception;

abstract class AbstractPrinciple implements Principle
{
  protected array $res = [];
  protected static ?string $principle = null;
  protected static array $questionList = [];
  protected float $totalScore = 0;
  protected array $staticPoints = [];
  protected array $dynamicPoints = [];
  protected array $weightings = [];

  public function __construct(array $res)
  {
    $this->res = $res;

    foreach (static::$questionList as $questionKey) {
      if (!array_key_exists($questionKey, $this->res)) {
        throw new Exception("Missing key in input array: {$questionKey}");
      }
    }

    $this->setUpMaps();
  }

  /**
   *totalScoreやstaticPointsなどを設問ごとにまとめる
   */
  private function setUpMaps(): void
  {
    $config = new PrincipleConfig();
    if (!isset($config)) {
      throw new Exception("Config data not found: $config");
    }

    $principleData = $config->getPrincipleData($this->getPrinciple());

    foreach (static::$questionList as $questionKey) {
      if (isset($principleData[$questionKey])) {
        $questionData = $principleData[$questionKey];

        if (isset($questionData['staticPoint'])) {
          $this->staticPoints[$questionKey] = $questionData['staticPoint'];
        }

        if (isset($questionData['dynamicPoint'])) {
          $this->dynamicPoints[$questionKey] = $questionData['dynamicPoint'];
        }

        if (isset($questionData['weighting'])) {
          $this->weightings[$questionKey] = $questionData['weighting'];
        }
      }
    }
  }

  public abstract function calculate(): float;

  public function getTotalScore(): float
  {
    return $this->totalScore;
  }

  public function addTotalScore(float $score): void
  {
    $this->totalScore += $score;
  }

  public static function getPrinciple(): string
  {
    // staticはselfと比べて遅延バインディングを行い、子クラスが$aliasをオーバーライドするとその値を使用します。
    // selfは常にこのクラスの値($alias = null)を使用します。
    return static::$principle !== null ? static::$principle : static::class;
  }

  /**
   * 子コマンドにログを取る方法を提供します。
   */
  protected function log(string $info): void
  {
    fwrite(STDOUT, $info . PHP_EOL);
  }
}
