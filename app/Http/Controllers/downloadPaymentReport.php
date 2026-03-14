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

        return Excel::download(
            new ComplaintReportExport($from_date, $to_date),
            'complaint_report.xlsx'
        );
        // return Excel::download(new ComplaintReportExport, 'complaint_report.xlsx');
    }
}
