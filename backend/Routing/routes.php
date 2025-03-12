<?php

namespace Routing;

use App\Controllers\DiagnosisController;
use App\Controllers\PDFController;
use Helpers\ValidationHelper;
use Response\HTTPRenderer;
use Response\Render\JSONRenderer;
use Response\Render\PDFRenderer;

return [
  "api/diagnosis" => [
    'POST' => function (): HTTPRenderer {
      $requestData = json_decode(file_get_contents('php://input'), true);
      $data = ValidationHelper::checkRequiredQuestions($requestData);

      $controller = new DiagnosisController($data);
      $diagnosis = $controller->store();
      return new JSONRenderer(["message" => "success", 'diagnosis' => $diagnosis]);
    },

    'PUT' => function (): HTTPRenderer {
      $requestData = json_decode(file_get_contents('php://input'), true);
      $data = ValidationHelper::checkRequiredQuestions($requestData);

      $controller = new DiagnosisController($data);
      // $diagnosis = $controller->update();
      $diagnosis = $controller->store();
      return new JSONRenderer(['diagnosis' => $diagnosis]);
    }
  ]
];
