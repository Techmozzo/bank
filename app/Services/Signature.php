<?php

namespace App\Services;

use App\Models\ConfirmationRequest;
use Carbon\Carbon;
use PDF;

class Signature
{
    public static function generatePdf($comfirmation_request)
    {
        // $opening_period =
        // $day = Carbon::parse(comfirmation_request->opening_period)
        // $month =
        $years = getYearRangeInStringFormat(getYearsInRange($comfirmation_request->opening_period, $comfirmation_request->closing_period));
        $period = '';
        $data = ['company' => $comfirmation_request->company, $period];
        // $pdf = PDF::loadView('pdf', $data);
        return $pdf->download('mypdf.pdf');
    }

    public static function uploadPdf($file): string
    {
        return storeFileLocally('confirmation_requests', $file);
    }
}
