<?php

namespace App\Services;

use Exception;
use Google\Client as Google_Client;
use Google\Service\Sheets as Google_Service_Sheets;
use Google\Service\Sheets\ValueRange as Google_Service_Sheets_ValueRange;
use Helpers\Settings;

class GoogleSheetsService
{
  private string $spreadsheetId;
  private string $range;
  private Google_Service_Sheets $service;

  /**
   * GoogleSheetsServiceのコンストラクタ
   * 
   * @throws Exception サービス初期化に失敗した場合
   */
  public function __construct()
  {
    try {
      // .envファイルの読み込みを確認
      if (!file_exists(dirname(__DIR__, 2) . '/.env')) {
        throw new Exception('.envファイルが見つかりません');
      }

      // 設定値の読み込み
      $settings = new Settings();
      $this->spreadsheetId = $settings->env("GOOGLE_SPREADSHEET_ID");
      if (empty($this->spreadsheetId)) {
        throw new Exception('スプレッドシートIDが設定されていません');
      }

      $this->range = 'フィードバック!A2:B';

      // 認証ファイルのパスを解決
      $keyFilePath = $settings->env('GOOGLE_APPLICATION_CREDENTIALS');
      if (empty($keyFilePath)) {
        throw new Exception('Google API認証情報のパスが設定されていません');
      }

      // プロジェクトルートからの相対パスを絶対パスに変換
      $absolutePath = dirname(__DIR__, 2) . '/' . $keyFilePath;
      if (!file_exists($absolutePath)) {
        throw new Exception('Google API認証ファイルが見つかりません: ' . $absolutePath);
      }

      $client = new Google_Client();
      $client->setAuthConfig($absolutePath);
      $client->addScope(Google_Service_Sheets::SPREADSHEETS);

      $this->service = new Google_Service_Sheets($client);
    } catch (Exception $e) {
      throw new Exception('Google Sheetsサービスの初期化に失敗しました: ' . $e->getMessage());
    }
  }

  /**
   * CSVインジェクション対策のためのデータサニタイズ
   * 
   * @param mixed $value サニタイズする値
   * @return string サニタイズされた値
   */
  private function sanitizeForCsvInjection($value): string
  {
    // 文字列に変換
    $value = (string)$value;

    // 数式の先頭文字を検出するパターン（=, +, -, @, 等）
    $dangerousPatterns = ['/^=/', '/^\\+/', '/^-/', '/^@/', '/^\\t=/'];

    // 危険な文字パターンで始まる場合は先頭にシングルクォートを追加
    if (preg_match('/^([=\\+\\-@\\t])/', $value)) {
      $value = "'" . $value;
    }

    return $value;
  }

  /**
   * 配列内の全ての値をサニタイズ
   * 
   * @param array $data サニタイズする配列
   * @return array サニタイズされた配列
   */
  private function sanitizeArray(array $data): array
  {
    $sanitized = [];
    foreach ($data as $value) {
      $sanitized[] = $this->sanitizeForCsvInjection($value);
    }
    return $sanitized;
  }

  /**
   * スプレッドシートに行を追加する
   * 
   * @param array $rowData 追加する行データ
   * @return bool 追加に成功したかどうか
   * @throws Exception 追加に失敗した場合
   */
  public function appendRow(array $rowData): bool
  {
    try {
      // CSVインジェクション対策
      $sanitizedRowData = $this->sanitizeArray($rowData);

      $body = new Google_Service_Sheets_ValueRange([
        'values' => [$sanitizedRowData]
      ]);

      $params = [
        'valueInputOption' => 'RAW'
      ];

      $result = $this->service->spreadsheets_values->append(
        $this->spreadsheetId,
        $this->range,
        $body,
        $params
      );

      return $result->getUpdates()->getUpdatedRows() > 0;
    } catch (Exception $e) {
      throw new Exception('スプレッドシートへの行の追加に失敗しました: ' . $e->getMessage());
    }
  }
}
