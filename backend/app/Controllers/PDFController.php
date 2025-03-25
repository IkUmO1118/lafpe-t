<?php

namespace App\Controllers;

use App\Services\PDFService;
use Response\Render\JSONRenderer;
use Exception;

class PDFController
{
  private array $data;
  private PDFService $pdfService;

  public function __construct(array $data)
  {
    $this->data = $data;
    $this->pdfService = new PDFService();
  }

  public function generatePDF(): string
  {
    try {

      $questionAnswers = $this->data['questionAnswers'] ?? [];
      $chartImage = $this->data['chartImage'] ?? '';

      $pdfContent = $this->pdfService->createDiagnosisPDF($questionAnswers, $chartImage);

      return $pdfContent;
    } catch (Exception $e) {
      throw new Exception($e->getMessage());
    }
  }
}
