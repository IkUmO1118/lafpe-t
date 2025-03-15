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

  public function generatePDF(): HTTPRenderer
  {
    try {
      $diagnosticResults = $this->data['diagnosticResults'];
      $pdfContent = $this->pdfService->createDiagnosisPDF($diagnosticResults);
      return new BinaryRenderer($pdfContent, [
        'Content-Type' => 'application/pdf',
        'Content-Disposition' => 'attachment; filename=diagnosis-result.pdf'
      ]);
    } catch (Exception $e) {
      error_log('Error generating PDF: ' . $e->getMessage());
      return new JSONRenderer([
        'status' => 'error',
        'message' => 'Failed to generate PDF'
      ]);
    }
  }
}
