<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ComplaintReportExport;

class DownloadPaymentReport extends Controller
{
   public function downloadPaymentReport(Request $request)
    {
        $from_date = $request->from_date;
        $to_date = $request->to_date;

        $fileName = 'complaint_report_' . time() . '.xlsx';

        Excel::store(
            new ComplaintReportExport($from_date, $to_date),
            'reports/' . $fileName,
            'public'
        );

        $downloadUrl = asset('storage/reports/' . $fileName);

        return response()->json([
            'status' => true,
            'message' => 'Report generated successfully',
            'download_url' => $downloadUrl
        ]);
    }
}
