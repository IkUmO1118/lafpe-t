<?php

namespace Helpers;

class ValidationHelper
{
  public static function checkRequiredQuestions(array $data)
  {
    if (!is_array($data)) {
      return false;
    }

    $requiredQuestions = ['Q1', 'Q2', 'Q3', 'Q4', 'Q5', 'Q6', 'Q7', 'Q8', 'Q9', 'Q10', 'Q11', 'Q12', 'Q13'];

    foreach ($requiredQuestions as $question) {
      if (!isset($data[$question])) {
        return false;
      }
    }

    return true;
  }
}
