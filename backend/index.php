<?php

spl_autoload_extensions(".php");
spl_autoload_register();

error_reporting(E_ALL);
ini_set('display_errors', '0');
ini_set('log_errors', '1');
ini_set('error_log', '/path/to/your/error.log');

require __DIR__ . '/vendor/autoload.php';

// Security headers
header("Content-Security-Policy: default-src 'self'; script-src 'self'; style-src 'self'; img-src 'self'; connect-src 'self'");
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: DENY");
header("X-XSS-Protection: 1; mode=block");
header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");
header("Referrer-Policy: strict-origin-when-cross-origin");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

// CORS headers
// Prod: https://example.com
header('Access-Control-Allow-Origin: http://localhost:5173');
header('Access-Control-Allow-Methods: GET, POST, PUT, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Credentials: true');

// Prod: false
$DEBUG = true;

$routes = include('Routing/routes.php');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
  // Preflightリクエストに対する応答
  http_response_code(200);
  exit();
}

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$path = ltrim($path, "/");
$method = $_SERVER['REQUEST_METHOD'];

// デバッグ用のログ追加
if ($DEBUG) {
  error_log("Request Path: " . $path . PHP_EOL);
  error_log("Request Method: " . $method);
}

if (isset($routes[$path])) {
  $route = $routes[$path];

  // ルートがメソッド別の配列の場合の処理
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
        $sanitized_value = filter_var($value, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

        if ($sanitized_value && $sanitized_value === $value) {
          header("{$name}: {$sanitized_value}");
        } else {
          throw new Exception("Invalid header value detected");
        }
      }

      // コンテンツの出力（1回だけ）
      echo $renderer->getContent();
    } catch (Exception $e) {
      http_response_code(500);
      header('Content-Type: application/json');
      echo json_encode([
        'error' => 'Internal error, please contact the admin.',
        // Prod: 'debug' => false,
        'debug' => $DEBUG ? $e->getMessage() : null
      ]);
    }
  } else {
    http_response_code(405);
    header('Content-Type: application/json');
    echo json_encode([
      'error' => 'Method Not Allowed',
      'message' => 'The requested method is not supported for this route.'
    ]);
  }
} else {
  http_response_code(404);
  header('Content-Type: application/json');
  echo json_encode([
    'error' => 'Not Found',
    'message' => 'The requested route was not found on this server.'
  ]);
}
