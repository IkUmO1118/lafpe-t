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

  public function getPrincipleData(string $principle): array
  {
    if (isset($this->configData[$principle])) {
      return $this->configData[$principle];
    }
    return [];
  }
}
