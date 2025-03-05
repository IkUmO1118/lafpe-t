<?php

namespace Tests\Unit\Helpers;

use PHPUnit\Framework\TestCase;
use Helpers\ValidationHelper;
use InvalidArgumentException;

class ValidationHelperTest extends TestCase
{
  public function testCheckRequiredQuestions_ValidData()
  {
    $validData = [
      'Q1' => 'value',
      'Q2' => 'value',
      'Q3' => 'value',
      'Q4' => 'value',
      'Q5' => 'value',
      'Q6' => 'value',
      'Q7' => 'value',
      'Q8' => 'value',
      'Q9' => 'value',
      'Q10' => 'value',
      'Q11' => 'value',
      'Q12' => 'value',
      'Q13' => 'value'
    ];

    $result = ValidationHelper::checkRequiredQuestions($validData);
    $this->assertEquals($validData, $result);
  }

  public function testCheckRequiredQuestions_MissingQuestion()
  {
    $this->expectException(\InvalidArgumentException::class);

    $incompleteData = [
      'Q1' => 'value',
      'Q2' => 'value'
      // 他の質問が欠落
    ];

    ValidationHelper::checkRequiredQuestions($incompleteData);
  }

  public function testCheckRequiredQuestions_NonArrayInput()
  {
    // 非配列データを渡して InvalidArgumentException を期待
    $this->expectException(InvalidArgumentException::class);
    $this->expectExceptionMessage('The provided value is not a valid data.');

    ValidationHelper::checkRequiredQuestions('string'); // 非配列データ
  }
}
