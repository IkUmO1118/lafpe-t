<?php

namespace App\Controllers;

use App\Services\GoogleSheetsService;
use Exception;

class FeedbackFormController
{
  private array $data = [];
  private GoogleSheetsService $sheetsService;

  public function __construct(array $data)
  {
    $this->data = $data;
    $this->sheetsService = new GoogleSheetsService();
  }

  /**
   * メッセージをGoogle Sheetsに保存する
   * 
   * @return array 処理結果
   * @throws Exception 保存に失敗した場合
   */
  public function store(): void
  {
    try {
      // 必須フィールドのチェック
      if (!isset($this->data['message']) || empty($this->data['message'])) {
        throw new Exception('メッセージが必要です');
      }

      // 現在のタイムスタンプを取得
      $timestamp = date('Y-m-d H:i:s');

      // スプレッドシートに保存するデータ
      $rowData = [
        $timestamp,
        $this->data['message']
      ];

      // Google Sheetsに追加
      $result = $this->sheetsService->appendRow($rowData);

      if (!$result) {
        throw new Exception('フィードバックの保存に失敗しました');
      }
    } catch (Exception $e) {
      throw new Exception($e->getMessage());
    }
  }
}
