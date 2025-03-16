<?php

namespace Config;

use Exception;

class QuestionConfig
{
  private array $configData;

  public function __construct()
  {
    $filePath = sprintf('%s/QuestionConfig.json', __DIR__);
    if (!file_exists($filePath)) {
      throw new Exception("Configuration file not found: $filePath");
    }

    $jsonData = file_get_contents($filePath);
    $this->configData = json_decode($jsonData, true);
  }

  public function getQuestionData(string $question): array
  {
    if (isset($this->configData[$question])) {
      return $this->configData[$question];
    }
    return [];
  }
}
