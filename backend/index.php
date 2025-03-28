<?php

require __DIR__ . '/vendor/autoload.php';



spl_autoload_extensions(".php");
spl_autoload_register();

if (!file_exists(__DIR__ . '/.env')) {
  throw new Exception('.env file not found');
}

use Helpers\Settings;

$settings = new Settings();

error_reporting(E_ALL);
ini_set('display_errors', '0');
ini_set('log_errors', '1');
ini_set('error_log', __DIR__ . '/error.log');



$isProd = ($_SERVER['SERVER_NAME'] === $settings->env('PROD_ORIGIN') || $settings->env('APP_ENV') === 'production');

$DEBUG = $isProd ? false : true;

$corsOrigin = $isProd ? $settings->env('PROD_ORIGIN') : $settings->env('DEV_ORIGIN');

// ===== セキュリティヘッダー =====
header("Content-Security-Policy: default-src 'self'; script-src 'self'; style-src 'self'; img-src 'self'; connect-src 'self'");
header("X-XSS-Protection: 1; mode=block");
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: DENY");
header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");
header("Referrer-Policy: strict-origin-when-cross-origin");
if ($isProd) {
  header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");
}

// ===== CORS設定 =====
header("Access-Control-Allow-Origin: {$corsOrigin}");
header('Access-Control-Allow-Methods: POST, PUT, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Credentials: true');

// ===== キャッシュ設定 =====
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

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
      if ($DEBUG) {
        error_log("Request Body: " . file_get_contents('php://input'));
      }

      $renderer = $route[$method]();

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
    http_response_code(405);
    echo json_encode([
      'error' => 'Method Not Allowed',
      'message' => 'The requested method is not supported for this route.'
    ]);
  }
} else {
  http_response_code(404);
  echo json_encode([
    'error' => 'Not Found',
    'message' => 'The requested route was not found on this server.'
  ]);
}
