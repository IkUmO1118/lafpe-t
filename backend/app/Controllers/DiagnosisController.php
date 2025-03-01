<?php

namespace app\Controllers;

use app\Services\CalcPrinciple1;
use app\Services\CalcPrinciple2;
use app\Services\CalcPrinciple3;
use Helpers\ValidationHelper;
use Response\HTTPRenderer;
use Response\Render\JSONRenderer;

class DiagnosisController
{
  private const PRINCIPLE1_QUESTIONS = ['Q3', 'Q13'];
  private const PRINCIPLE2_QUESTIONS = ['Q1', 'Q2', 'Q3', 'Q5', 'Q6', 'Q7', 'Q8'];
  private const PRINCIPLE3_QUESTIONS = ["Q3", "Q4", 'Q5', 'Q6', 'Q7', 'Q8', "Q9"];
  // private const PRINCIPLE4_QUESTIONS = ['Q1', 'Q2', 'Q3', 'Q4', 'Q5', 'Q6', 'Q7', 'Q10'];
  // private const PRINCIPLE5_QUESTIONS = ["Q3", "Q12"];
  // private const PRINCIPLEDP_QUESTIONS = ["Q4", "Q11"];

  public function store(): HTTPRenderer
  {
    try {
      // $requestData = json_decode(file_get_contents('php://input'), true);

      $requestData = [
        'Q1' => [1],
        'Q2' => [0, 1],
        'Q3' => [
          'openRack' => [
            'isChecked' => false,
            'per'       => null,
            'times'     => null,
          ],
          'IVCRack' => [
            'isChecked' => false,
            'per'       => null,
            'times'     => null,
          ],
          'positiveRack' => [
            'isChecked' => true,
            'per'       => 0,
            'times'     => 3,
          ],
          'negativeRack' => [
            'isChecked' => false,
            'per'       => null,
            'times'     => null,
          ],
          'oneWayAirflowRack' => [
            'isChecked' => true,
            'per'       => 4,
            'times'     => 2,
          ],
          'isolator' => [
            'isChecked' => false,
            'per'       => null,
            'times'     => null,
          ],
        ],
        'Q4'  => 1,
        'Q5'  => 0,
        'Q6'  => 2,
        'Q7'  => [1],
        'Q8'  => [0],
        'Q9'  => [0, 1],
        'Q10' => [3],
        'Q11' => [0, 1],
        'Q12' => [1, 2, 4, 8, 11, 12],
        'Q13' => [0],
      ];

      if (!ValidationHelper::checkRequiredQuestions($requestData)) {
        throw new \InvalidArgumentException('Invalid request data format');
      }

      // 各原則用のデータを抽出してからインスタンス化
      $principle1Data = array_intersect_key($requestData, array_flip(self::PRINCIPLE1_QUESTIONS));
      $principle2Data = array_intersect_key($requestData, array_flip(self::PRINCIPLE2_QUESTIONS));
      $principle3Data = array_intersect_key($requestData, array_flip(self::PRINCIPLE3_QUESTIONS));

      $principle1 = new CalcPrinciple1($principle1Data);
      $principle2 = new CalcPrinciple2($principle2Data);
      $principle3 = new CalcPrinciple3($principle3Data);

      $result = [
        'principle1' => $principle1->calculate(),
        'principle2' => $principle2->calculate(),
        'principle3' => $principle3->calculate()
      ];

      echo "\nCalculation results:\n";
      print_r($result);

      return new JSONRenderer([
        'data' => $result
      ]);
    } catch (\Exception $e) {
      return new JSONRenderer([
        'status' => 'error',
        'message' => $e->getMessage()
      ], 500);
    }
  }

  public function update(): JSONRenderer
  {
    return new JSONRenderer([
      'status' => 'success',
    ]);
  }
}
