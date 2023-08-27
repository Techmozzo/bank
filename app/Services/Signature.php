<?php

namespace App\Services;

use App\Models\ConfirmationRequest;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Carbon\Carbon;

class Signature
{
    public static function generatePdf(ConfirmationRequest $comfirmation_request)
    {
        $years = getYearsInStringFormat(getYearsInRange($comfirmation_request->opening_period, $comfirmation_request->closing_period));
        $period = getPeriodDayAndMonth($comfirmation_request->opening_period) .' '. $years;
        $data = ['company' => $comfirmation_request->company, 'signatories' => $comfirmation_request->signatory, 'period' => $period];
        $pdf = FacadePdf::loadView('signature.index', $data);
        $file_name = strtolower(str_replace(' ', '_', $comfirmation_request->name)).'_'.time().'.pdf';
        // $file = $pdf->download($file_name);
        $pdfPath = public_path('store/confirmation_requests/' . $file_name);
        file_put_contents($pdfPath, $pdf->output());
        return $pdfPath;
    }

    public static function uploadPdf(ConfirmationRequest $comfirmation_request): string
    {
        return '';
    }
}
