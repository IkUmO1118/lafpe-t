<?php

namespace Routing;

use App\Controllers\DiagnosisController;
use App\Controllers\FeedbackFormController;
use App\Controllers\PDFController;
use Exception;
use Helpers\ValidationHelper;
use Response\HTTPRenderer;
use Response\Render\BinaryRenderer;
use Response\Render\JSONRenderer;

return [
  "api/diagnosis" => [
    'POST' => function (): HTTPRenderer {
      $requestData = json_decode(file_get_contents('php://input'), true);
      $data = ValidationHelper::checkRequiredQuestions($requestData);

      $controller = new DiagnosisController($data);
      $diagnosis = $controller->store();
      return new JSONRenderer(["status" => "success", 'diagnosis' => $diagnosis]);
    },

    'PUT' => function (): HTTPRenderer {
      $requestData = json_decode(file_get_contents('php://input'), true);
      $data = ValidationHelper::checkRequiredQuestions($requestData);

      $controller = new DiagnosisController($data);
      // $diagnosis = $controller->update();
      $diagnosis = $controller->store();
      return new JSONRenderer(['status' => 'success', 'diagnosis' => $diagnosis]);
    }
  ],
  "api/feedback" => [
    'POST' => function (): HTTPRenderer {
      $requestData = json_decode(file_get_contents('php://input'), true);
      $data = ValidationHelper::string($requestData);

      $controller = new FeedbackFormController($data);
      $controller->store();
      return new JSONRenderer([
        'status' => "success",
        'message' => 'Message successfully stored'
      ]);
    }
  ],

  "api/download/pdf" => [
    "POST" => function (): HTTPRenderer {
      $requestData = json_decode(file_get_contents('php://input'), true);

      $questionAnswers = ValidationHelper::checkRequiredQuestions($requestData['questionAnswers']);

      if (
        !isset($requestData['chartImage']) ||
        !isset($questionAnswers)
      ) {
        throw new Exception("Required data missing");
      }

      $controller = new PDFController($requestData);
      $pdfContent = $controller->generatePDF();

      return new BinaryRenderer($pdfContent, [
        'Content-Type' => 'application/pdf',
        'Content-Disposition' => 'attachment; filename=lafpe-t.pdf'
      ]);
    }
  ]
];
