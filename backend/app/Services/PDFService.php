<?php

namespace App\Services;

use Config\QuestionConfig;
use Exception;
use TCPDF;

class PDFService
{
  private QuestionConfig $questionConfig;

  public function __construct()
  {
    $this->questionConfig = new QuestionConfig();
  }

  public function createDiagnosisPDF(array $diagnosticResults, array $questionAnswers): string
  {
    try {
      $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8');
      $pdf->setPrintHeader(false);
      $pdf->setPrintFooter(false);
      $pdf->SetMargins(15, 15, 15);
      $pdf->SetAutoPageBreak(true, 15);
      $pdf->AddPage();

      // 日本語フォントの設定
      $pdf->SetFont('kozminproregular', '', 11);

      // タイトル
      $pdf->SetFont('kozminproregular', 'B', 16);
      $pdf->Cell(0, 10, '実験動物施設診断結果', 0, 1, 'C');
      $pdf->Ln(5);

      //-----------------------------------------------------
      // 結果の表示
      $pdf->SetFont('kozminproregular', 'B', 12);
      $pdf->Cell(0, 8, '診断結果内容', 0, 1, 'L');
      $pdf->Ln(2);

      $principleTypes = [
        "principle1" => "原則１",
        "principle2" => "原則２",
        "principle3" => "原則３",
        "principle4" => "原則４",
        "principle5" => "原則５",
        "principleDP" => "DP",
      ];

      $pdf->SetFont('kozminproregular', '', 11);
      foreach ($diagnosticResults as $key => $value) {
        if (is_numeric($value)) {
          $pdf->Cell(80, 7, $principleTypes[$key] . '： ' . number_format($value, 2), 0, 1);
        }
      }
      $pdf->Ln(10);

      //-----------------------------------------------------
      // 設問と回答の表示
      $pdf->SetFont('kozminproregular', 'B', 12);
      $pdf->Cell(0, 8, '回答内容', 0, 1, 'L');
      $pdf->Ln(4);

      foreach ($questionAnswers as $qKey => $answer) {
        if ($qKey === 'Q3') {
          $this->renderQ3Details($pdf, $answer);
          continue;
        }

        $questionData = $this->questionConfig->getQuestionData($qKey);

        if (empty($questionData)) {
          continue;
        }

        $pdf->SetFont('kozminproregular', 'B', 11);
        $pdf->MultiCell(0, 7, $qKey . '. ' . $questionData['title'], 0, 'L');
        $pdf->SetFont('kozminproregular', '', 10);

        if (is_array($answer) && isset($questionData['option'])) {

          foreach ($answer as $selectedKey) {
            if (isset($questionData['option'][$selectedKey])) {
              $pdf->Cell(3, 5, '', 0);
              $pdf->Cell(5, 5, '•', 0);
              $pdf->MultiCell(0, 5, $questionData['option'][$selectedKey], 0, 'L');
            }
          }
        } elseif (is_scalar($answer) && isset($questionData['option'][$answer])) {
          $pdf->Cell(3, 5, '', 0);
          $pdf->Cell(5, 5, '•', 0);
          $pdf->MultiCell(0, 5, $questionData['option'][$answer], 0, 'L');
        }

        $pdf->Ln(5);
      }

      //-----------------------------------------------------
      // 作成日の表示
      $pdf->Ln(5);
      $pdf->Cell(0, 7, '作成日： ' . date('Y年m月d日'), 0, 1, 'R');

      return $pdf->Output('', 'S');
    } catch (Exception $e) {
      throw new Exception('PDF生成エラー: ' . $e->getMessage());
    }
  }

  private function renderQ3Details(TCPDF $pdf, array $answer): void
  {
    $questionData = $this->questionConfig->getQuestionData('Q3');

    if (empty($questionData)) {
      return;
    }

    $pdf->SetFont('kozminproregular', 'B', 11);
    $pdf->MultiCell(0, 10, 'Q3. ' . $questionData['title'], 0, 'L');
    $pdf->SetFont('kozminproregular', '', 10);

    $rackTypes = [
      'openRack' => 'オープンラック',
      'IVCRack' => 'IVCラック',
      'positiveRack' => '陽圧ラック',
      'negativeRack' => '陰圧ラック',
      'oneWayAirflowRack' => '一方向気流ラック',
      'isolator' => 'アイソレーター'
    ];

    foreach ($rackTypes as $rackKey => $rackName) {
      if (isset($answer[$rackKey]) && $answer[$rackKey]['isChecked']) {
        $pdf->Cell(3, 5, '', 0);
        $pdf->Cell(0, 7, "- {$rackName}", 0, 1);

        if (
          in_array($rackKey, ['IVCRack', 'positiveRack', 'negativeRack']) &&
          isset($answer[$rackKey]['per']) &&
          isset($answer[$rackKey]['times'])
        ) {

          $perValue = $answer[$rackKey]['per'];
          $timesValue = $answer[$rackKey]['times'];

          $perText = isset($questionData['per'][$perValue]) ? $questionData['per'][$perValue] : '';
          $timesText = isset($questionData['times'][$timesValue]) ? $questionData['times'][$timesValue] : '';

          $pdf->Cell(10, 7, '', 0);
          $pdf->Cell(0, 7, "使用割合： {$perText}", 0, 1);
          $pdf->Cell(10, 7, '', 0);
          $pdf->Cell(0, 7, "換気回数： {$timesText}", 0, 1);
        }
      }
    }

    $pdf->Ln(5);
  }
}
