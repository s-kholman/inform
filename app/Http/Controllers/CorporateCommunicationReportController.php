<?php

namespace App\Http\Controllers;

use App\Models\PhoneDetail;

class CorporateCommunicationReportController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(PhoneDetail $phoneDetail)
    {
        if ($phoneDetail->DetailDate == null){
            $phoneDetail = PhoneDetail::query()->latest('DetailDate')->first();
        }
        return view('\corporateCommunication\report', [
            'itogTable' => json_decode($phoneDetail->DetailViewJSON),
            'DetailDate' => $phoneDetail->DetailDate
        ]);
    }
}
