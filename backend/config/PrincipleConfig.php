<?php

namespace config;

use Exception;

class PrincipleConfig
{
  private array $configData;

  public function __construct()
  {
    $filePath = sprintf('%s/PrincipleConfig.json', __DIR__);
    if (!file_exists($filePath)) {
      throw new Exception("Configuration file not found: $filePath");
    }

    $jsonData = file_get_contents($filePath);
    $this->configData = json_decode($jsonData, true);
  }

  public function getStaticPoint(string $principle, string $question): array | float
  {
    $staticPoint = $this->configData[$principle][$question]["staticPoint"];
    if (isset($staticPoint)) {
      return $staticPoint;
    }
    return 0;
  }

  public function getWeighting(string $principle, string $question): array | float
  {
    $weighting = $this->configData[$principle][$question]["weighting"];
    if (isset($weighting)) {
      return $weighting;
    }
    return 0;
  }
}
