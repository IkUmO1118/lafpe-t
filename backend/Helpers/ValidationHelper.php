<?php

namespace Helpers;

use InvalidArgumentException;

class ValidationHelper
{
  public static function checkRequiredQuestions(array $data): array
  {
    if (!is_array($data)) {
      throw new InvalidArgumentException('入力データが配列形式ではありません');
    }

    $requiredQuestions = ['Q1', 'Q2', 'Q3', 'Q4', 'Q5', 'Q6', 'Q7', 'Q8', 'Q9', 'Q10', 'Q11', 'Q12', 'Q13'];

    foreach ($requiredQuestions as $question) {
      if (!array_key_exists($question, $data)) {
        throw new InvalidArgumentException("設問{$question}の回答が入力されていません。");
      }
    }

    return $data;
  }

  public static function checkRequiredPrinciples(array $data): array
  {
    if (!is_array($data)) {
      throw new InvalidArgumentException('入力データが配列形式ではありません');
    }

    $requiredPrinciples = ["principle1", "principle2", "principle3", "principle4", "principle5", "principleDP"];

    foreach ($requiredPrinciples as $principle) {
      if (!isset($data[$principle])) {
        throw new InvalidArgumentException("原則「{$principle}」のデータが不足しています");
      }
    }

    return $data;
  }

  public static function string(array $value): array
  {
    if (!isset($value["message"]) || !is_string($value["message"])) {
      throw new InvalidArgumentException('メッセージは文字列で入力してください');
    }

    $message = trim($value["message"]);

    if (mb_strlen($message, 'UTF-8') > 255) {
      throw new InvalidArgumentException('Tメッセージは255文字以内で入力してください');
    }

    $message = preg_replace('/[\x00-\x1F\x7F]/u', '', $message);

    if (preg_match('/(UNION|SELECT|INSERT|UPDATE|DELETE|DROP|--)/i', $message)) {
      throw new InvalidArgumentException('不正な入力が検出されました');
    }

    $sanitized = htmlspecialchars(strip_tags($message), ENT_QUOTES | ENT_HTML5, 'UTF-8');

    if ($sanitized === '' && $sanitized !== '0') {
      throw new InvalidArgumentException('有効なメッセージを入力してください');
    }

    return ['message' => $sanitized];
  }
}
