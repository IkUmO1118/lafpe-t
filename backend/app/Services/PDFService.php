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

  public function createDiagnosisPDF(array $questionAnswers, string $chartImage): string
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
      // 画像データの処理
      if (!empty($chartImage)) {
        $pdf->Ln(5);
        $this->processChartImage($pdf, $chartImage);
      }
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

        if (empty($answer) || (is_array($answer) && count($answer) === 0)) {
          $pdf->Cell(3, 5, '', 0);
          $pdf->Cell(0, 5, '※ 選択されたデータがありません', 0, 1, 'L');
        } elseif (is_array($answer) && isset($questionData['option'])) {
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

      // PDFを出力
      $pdfContent = $pdf->Output('', 'S'); // 文字列として出力
      return $pdfContent;
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

    $anyRackSelected = false;
    foreach ($rackTypes as $rackKey => $rackName) {
      if (isset($answer[$rackKey]) && $answer[$rackKey]['isChecked']) {
        $anyRackSelected = true;
        break;
      }
    }

    // If no rack is selected, show the "no data" message
    if (!$anyRackSelected) {
      $pdf->Cell(3, 5, '', 0);
      $pdf->Cell(0, 5, '※ 選択されたデータがありません', 0, 1, 'L');
      $pdf->Ln(5);
      return;
    }

    foreach ($rackTypes as $rackKey => $rackName) {
      if (isset($answer[$rackKey]) && $answer[$rackKey]['isChecked']) {
        $pdf->Cell(3, 5, '', 0);
        $pdf->Cell(0, 7, "- {$rackName}", 0, 1);

        if (
          isset($answer[$rackKey]['per']) &&
          isset($answer[$rackKey]['times'])
        ) {

          $perValue = $answer[$rackKey]['per'];
          $timesValue = $answer[$rackKey]['times'];

          $perText = isset($questionData['option']['per'][$perValue])
            ? $questionData['option']['per'][$perValue]
            : '';
          $timesText = isset($questionData['option']['times'][$timesValue])
            ? $questionData['option']['times'][$timesValue]
            : '';

          $pdf->Cell(10, 7, '', 0);
          $pdf->Cell(0, 7, "使用割合： {$perText}", 0, 1);
          $pdf->Cell(10, 7, '', 0);
          $pdf->Cell(0, 7, "換気回数： {$timesText}", 0, 1);
        }
      }
    }

    $pdf->Ln(5);
  }

  private function processChartImage(TCPDF $pdf, string $chartImage): void
  {
    if (empty($chartImage)) {
      $pdf->Cell(0, 10, '※ 画像データがありません', 0, 1, 'C');
      $pdf->Ln(5);
      return;
    }

    try {
      // Base64部分のみを抽出（JPEG形式に対応）
      $base64Data = preg_match('/^data:image\/jpeg;base64,(.*)$/', $chartImage, $matches)
        ? $matches[1]
        : (strpos($chartImage, ',') !== false
          ? substr($chartImage, strpos($chartImage, ',') + 1)
          : $chartImage);

      // デコード
      $imageData = base64_decode($base64Data, true);
      if ($imageData === false) {
        throw new Exception('画像データのBase64デコードに失敗しました');
      }

      // 一時ファイルに保存（拡張子をjpgに）
      $tempFile = tempnam(sys_get_temp_dir(), 'chart') . '.jpg';
      if (file_put_contents($tempFile, $imageData) === false) {
        throw new Exception('一時ファイルの作成に失敗しました');
      }

      // 画像が有効かチェック
      $imageInfo = getimagesize($tempFile);
      if ($imageInfo === false || $imageInfo[2] !== IMAGETYPE_JPEG) {
        throw new Exception('有効なJPEG画像ファイルではありません');
      }

      // 画像のサイズを計算（A4サイズに収まるよう調整）
      $pageWidth = $pdf->getPageWidth() - 30; // ページ幅から余白を引く

      $ratio = $pageWidth / $imageInfo[0]; // アスペクト比を計算
      $imgWidth = $pageWidth;
      $imgHeight = $imageInfo[1] * $ratio;

      // 現在のページに十分なスペースがあるか確認
      $currentY = $pdf->GetY();
      if ($currentY + $imgHeight > $pdf->getPageHeight() - 20) {
        $pdf->AddPage(); // 新しいページを追加
        $currentY = $pdf->GetY();
      }

      // PDFに画像を追加（JPEG形式として指定）
      $pdf->Image($tempFile, 15, $currentY, $imgWidth, $imgHeight, 'JPEG');

      // 画像の後に改行を追加
      $pdf->SetY($currentY + $imgHeight + 10);

      // 一時ファイルを削除
      if (file_exists($tempFile)) {
        unlink($tempFile);
      }

      // 画像処理成功ログ
      error_log('JPEG chart image successfully added to PDF');
    } catch (Exception $e) {
      // 画像処理に失敗してもPDFの生成は続行
      error_log('Failed to process chart image: ' . $e->getMessage());
      $pdf->Cell(0, 10, '※ 画像の表示に失敗しました: ' . $e->getMessage(), 0, 1, 'C');
      $pdf->Ln(10);
    }
  }
}
