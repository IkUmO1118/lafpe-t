<?php

// 外部ライブラリの自動読み込み
require __DIR__ . '/vendor/autoload.php';

// オートローダーの設定
spl_autoload_extensions(".php");
spl_autoload_register();

// すべてのエラーを報告
error_reporting(E_ALL);
// ユーザー画面にエラー表示を行わない
ini_set('display_errors', '0');
// エラーをログに記録
ini_set('log_errors', '1');
// エラーログの保存先を指定
ini_set('error_log', __DIR__ . '/error.log');


// コンテンツセキュリティポリシー: 自身のオリジンからのみリソースを読み込む
header("Content-Security-Policy: default-src 'self'; script-src 'self'; style-src 'self'; img-src 'self'; connect-src 'self'");
// MIMEタイプスニッフィングの防止
header("X-Content-Type-Options: nosniff");
// クリックジャッキング対策：iframe等での埋め込み禁止
header("X-Frame-Options: DENY");
// ブラウザ内蔵のXSSフィルタ有効化（検出時はレンダリングをブロック）
header("X-XSS-Protection: 1; mode=block");
// HTTPSを強制する HSTS：1年間有効、サブドメインも対象、preloadリスト登録可能
header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");
// リファラポリシー：同一オリジンでは完全なURL、クロスオリジンではオリジンのみ送信
header("Referrer-Policy: strict-origin-when-cross-origin");
// キャッシュの無効化（2重指定しているが、意図的に強化）
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

// ※ Dev : http://localhost:5173 Prod : https://example.com
header('Access-Control-Allow-Origin: http://localhost:5173');
header('Access-Control-Allow-Methods: POST, PUT, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Credentials: true');

// デバッグ用のフラグ
$DEBUG = true;

// タイムゾーンを日本時間に設定
date_default_timezone_set('Asia/Tokyo');

// ルーティングファイルのインクルード
$routes = include(__DIR__ . '/Routing/routes.php');

// OPTIONS メソッドの処理
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
  http_response_code(200);
  exit();
}

// パスの取得と検証
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$path = ltrim($path, "/");
if (strpos($path, '..') !== false || !preg_match('/^api\/[a-zA-Z0-9\-_\/]+$/', $path)) {
  http_response_code(400);
  exit('Invalid path');
}

// リクエストメソッドの取得
$method = $_SERVER['REQUEST_METHOD'];

// デバッグ用のログ追加
if ($DEBUG) {
  error_log("Request Path: " . $path . PHP_EOL);
  error_log("Request Method: " . $method);
}

// ルートにパスが存在するかチェックする
if (isset($routes[$path])) {
  $route = $routes[$path];

  // ルートのメソッドが存在するかチェックする
  if (is_array($route) && isset($route[$method])) {
    try {
      // リクエストボディのデバッグログ
      if ($DEBUG) {
        error_log("Request Body: " . file_get_contents('php://input'));
      }

      $renderer = $route[$method]();

      // レスポンスのデバッグログ
      if ($DEBUG) {
        error_log("Response: " . $renderer->getContent());
      }

      // ヘッダーの設定
      foreach ($renderer->getFields() as $name => $value) {
        // ヘッダーに対する単純な検証を実行
        $sanitized_value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');

        // サニタイズ後の値が元の値と一致するか確認します。
        if ($sanitized_value && $sanitized_value === $value) {
          header("{$name}: {$sanitized_value}");
        } else {
          // ヘッダー設定に失敗した場合、ログに記録するか処理します。
          // エラー処理によっては、例外をスローするか、デフォルトのまま続行することもできます。
          error_log("Failed setting header - original name: '$name', sanitized name: '$sanitized_name', original value: '$value', sanitized value: '$sanitized_value'");
          http_response_code(500);
          if ($DEBUG) print("Failed setting header - original: '$value', sanitized: '$sanitized_value'");
          exit;
        }
      }

      // コンテンツの出力（1回だけ）
      echo $renderer->getContent();
    } catch (Exception | InvalidArgumentException $e) {
      http_response_code(500);

      $errorMessage = $e->getMessage();

      echo json_encode([
        'status' => 'error',
        'message' => $errorMessage
      ]);

      if ($DEBUG) {
        error_log("Error: " . $e->getMessage());
      }
    }
  } else {
    // メソッドがサポートされていない場合、405エラーを表示します。
    http_response_code(405);
    echo json_encode([
      'error' => 'Method Not Allowed',
      'message' => 'The requested method is not supported for this route.'
    ]);
  }
} else {
  // マッチするルートがない場合、404エラーを表示します。
  http_response_code(404);
  echo json_encode([
    'error' => 'Not Found',
    'message' => 'The requested route was not found on this server.'
  ]);
}
