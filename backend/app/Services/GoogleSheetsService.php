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
   * スプレッドシートに行を追加する
   * 
   * @param array $rowData 追加する行データ
   * @return bool 追加に成功したかどうか
   * @throws Exception 追加に失敗した場合
   */
  public function appendRow(array $rowData): bool
  {
    try {
      $body = new Google_Service_Sheets_ValueRange([
        'values' => [$rowData]
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
