<?php

namespace Helpers;

use InvalidArgumentException;

class ValidationHelper
{
  public static function checkRequiredQuestions(array $data): array
  {
    if (!is_array($data)) {
      throw new InvalidArgumentException('The provided value is not a valid data.');
    }

    $requiredQuestions = ['Q1', 'Q2', 'Q3', 'Q4', 'Q5', 'Q6', 'Q7', 'Q8', 'Q9', 'Q10', 'Q11', 'Q12', 'Q13'];

    foreach ($requiredQuestions as $question) {
      if (!isset($data[$question])) {
        throw new InvalidArgumentException('The provided value is not a valid data.');
      }
    }

    return $data;
  }

  public static function checkRequiredPrinciples(array $data): array
  {
    if (!is_array($data)) {
      throw new InvalidArgumentException('The provided value is not a valid data.');
    }

    $requiredPrinciples = ["principle1", "principle2", "principle3", "principle4", "principle5", "principleDP"];

    foreach ($requiredPrinciples as $principle) {
      if (!isset($data[$principle])) {
        throw new InvalidArgumentException('The provided value is not a valid data.');
      }
    }

    return $data;
  }

  public static function string(array $value): array
  {
    if (!isset($value["message"]) || !is_string($value["message"])) {
      throw new InvalidArgumentException('The provided value must be a string.');
    }

    $message = trim($value["message"]);

    if (mb_strlen($message, 'UTF-8') > 255) {
      throw new InvalidArgumentException('The provided value exceeds the maximum length of 255 characters.');
    }

    $message = preg_replace('/[\x00-\x1F\x7F]/u', '', $message);

    if (preg_match('/(UNION|SELECT|INSERT|UPDATE|DELETE|DROP|--)/i', $message)) {
      throw new InvalidArgumentException('Invalid input detected.');
    }

    $sanitized = htmlspecialchars(strip_tags($message), ENT_QUOTES | ENT_HTML5, 'UTF-8');

    if ($sanitized === '' && $sanitized !== '0') {
      throw new InvalidArgumentException('The provided value is not a valid string.');
    }

    return ['message' => $sanitized];
  }
}
