<?php

namespace App\Services;

use Exception;
use TCPDF;

class PDFService
{
  public function createDiagnosisPDF(array $diagnosticResults): string
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
      $pdf->Cell(0, 10, '診断結果', 0, 1, 'C');
      $pdf->Ln(5);

      // 結果の表示
      $pdf->SetFont('kozminproregular', '', 11);
      foreach ($diagnosticResults as $key => $value) {
        if (is_numeric($value)) {
          $pdf->Cell(80, 10, $key . ': ' . number_format($value, 2), 0, 1);
        }
      }

      $pdf->Ln(5);
      $pdf->Cell(0, 7, '作成日: ' . date('Y年m月d日'), 0, 1, 'R');

      return $pdf->Output('', 'S');
    } catch (Exception $e) {
      throw new Exception('PDF生成エラー: ' . $e->getMessage());
    }
  }
}
