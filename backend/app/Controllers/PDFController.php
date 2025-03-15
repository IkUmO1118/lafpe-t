<?php

namespace App\Controllers;

use App\Services\PDFService;
use Response\Render\JSONRenderer;
use Exception;
use Response\HTTPRenderer;
use Response\Render\BinaryRenderer;

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
      $diagnosticResults = $this->data['diagnosticResults'];
      $pdfContent = $this->pdfService->createDiagnosisPDF($diagnosticResults);

      return $pdfContent;
    } catch (Exception $e) {
      error_log('Error generating PDF: ' . $e->getMessage());
      throw new Exception("Error generating PDF");
    }
  }
}
