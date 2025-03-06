<?php

namespace App\Controllers;

use App\Services\CalcPrinciple1;
use App\Services\CalcPrinciple2;
use App\Services\CalcPrinciple3;
use App\Services\CalcPrinciple4;
use App\Services\CalcPrinciple5;
use App\Services\CalcPrincipleDP;
use Exception;

class DiagnosisController
{
  private array $data = [];
  private const PRINCIPLE1_QUESTIONS = ['Q3', 'Q13'];
  private const PRINCIPLE2_QUESTIONS = ['Q1', 'Q2', 'Q3', 'Q5', 'Q6', 'Q7', 'Q8'];
  private const PRINCIPLE3_QUESTIONS = ["Q3", "Q4", 'Q5', 'Q6', 'Q7', 'Q8', "Q9"];
  private const PRINCIPLE4_QUESTIONS = ['Q1', 'Q2', 'Q3', 'Q4', 'Q5', 'Q6', 'Q7', 'Q10'];
  private const PRINCIPLE5_QUESTIONS = ["Q3", "Q12"];
  private const PRINCIPLEDP_QUESTIONS = ["Q4", "Q11"];

  public function __construct(array $data)
  {
    $this->data = $data;
  }

  public function store(): array
  {
    // 各原則用のデータを抽出してからインスタンス化
    $principle1Data = array_intersect_key($this->data, array_flip(self::PRINCIPLE1_QUESTIONS));
    $principle2Data = array_intersect_key($this->data, array_flip(self::PRINCIPLE2_QUESTIONS));
    $principle3Data = array_intersect_key($this->data, array_flip(self::PRINCIPLE3_QUESTIONS));
    $principle4Data = array_intersect_key($this->data, array_flip(self::PRINCIPLE4_QUESTIONS));
    $principle5Data = array_intersect_key($this->data, array_flip(self::PRINCIPLE5_QUESTIONS));
    $principleDPData = array_intersect_key($this->data, array_flip(self::PRINCIPLEDP_QUESTIONS));

    $principle1 = new CalcPrinciple1($principle1Data);
    $principle2 = new CalcPrinciple2($principle2Data);
    $principle3 = new CalcPrinciple3($principle3Data);
    $principle4 = new CalcPrinciple4($principle4Data);
    $principle5 = new CalcPrinciple5($principle5Data);
    $principleDP = new CalcPrincipleDP($principleDPData);

    $result = [
      'principle1' => $principle1->calculate(),
      'principle2' => $principle2->calculate(),
      'principle3' => $principle3->calculate(),
      'principle4' => $principle4->calculate(),
      'principle5' => $principle5->calculate(),
      'principleDP' => $principleDP->calculate(),
    ];

    if (!$result) throw new Exception('Failed to store diagnosis data');

    return $result;
  }

  public function update(): array
  {
    return [];
  }
}
