<?php

namespace Routing;

use app\Controllers\DiagnosisController;
use Helpers\ValidationHelper;
use Response\HTTPRenderer;
use Response\Render\JSONRenderer;

return [
  "api/diagnosis" => [
    'POST' => function (): HTTPRenderer {
      $requestData = json_decode(file_get_contents('php://input'), true);
      $data = ValidationHelper::checkRequiredQuestions($requestData);

      $controller = new DiagnosisController($data);
      $diagnosis = $controller->store();
      return new JSONRenderer(['diagnosis' => $diagnosis]);
    },

    'PUT' => function (): HTTPRenderer {
      $requestData = json_decode(file_get_contents('php://input'), true);
      $data = ValidationHelper::checkRequiredQuestions($requestData);

      $controller = new DiagnosisController($data);
      $diagnosis = $controller->update();
      return new JSONRenderer(['diagnosis' => $diagnosis]);
    }
  ]
];
