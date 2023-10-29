<?php

namespace App\Services;

use Dompdf\Dompdf;
use Dompdf\Options;

class PDFService
{
    private $domPdf;
    public function __construct() {
        $this->domPdf = new Dompdf();
        $pdfOptions = new Options();
        // Police par défaut
        $pdfOptions->set('defaultFont', 'Garamond');
        // Format du papier
        $this->domPdf->setPaper('A4', "portrait");
        $this->domPdf->setOptions($pdfOptions);
    }

    public function showPdfFile($html, $filename){
        $this->domPdf->loadHtml($html);
        $this->domPdf->render();
        $this->domPdf->stream($filename, [
            'Attachement' => false
        ]);
    }

    public function generatePDF($html) {
        $this->domPdf->loadHtml($html);
        $this->domPdf->render();
        $this->domPdf->output();
    }
}
