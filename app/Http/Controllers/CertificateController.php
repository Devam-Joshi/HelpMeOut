<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Certificate;
use App\Models\Compalin;
use Carbon\Carbon;

class CertificateController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'complaint_id' => 'required|exists:complains,id',
        ]);

        // Get complaint
        $complaint = Compalin::where('id', $request->complaint_id)->first();

        // Check if certificate already generated
        if ($complaint->is_certificate_generate == 1) {

            // get existing certificate
            $certificate = Certificate::where('complaint_id', $request->complaint_id)->first();

            $pdfFileName = str_replace('/', '-', $certificate->certificate_number) . '.pdf';

            return response()->json([
                'status' => 'success',
                'message' => 'Certificate already generated',
                'download_url' => asset('storage/certificates/' . $pdfFileName)
            ]);
        }

        // -----------------------------
        // FINANCIAL YEAR + MONTH
        // -----------------------------
        $today = Carbon::now();

        if ($today->month >= 4) {
            $financialYear = $today->year . '-' . substr($today->year + 1, 2);
        } else {
            $financialYear = ($today->year - 1) . '-' . substr($today->year, 2);
        }

        $month = $today->format('m');

        // -----------------------------
        // INCREMENT NUMBER
        // -----------------------------
        $lastCertificate = Certificate::latest()->first();
        $nextNumber = $lastCertificate ? $lastCertificate->id + 1 : 1;
        $increment = str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        $certificate_number = "SSFS/$financialYear/$month/$increment";

        // -----------------------------
        // ISSUE DATE & DUE DATE
        // -----------------------------
        $issueDate = Carbon::parse($request->issue_date);
        $dueDate = $issueDate->copy()->addYear()->subDay();
        $dueDateFormatted = $dueDate->format('Y-m-d');

        // -----------------------------
        // SAVE CERTIFICATE
        // -----------------------------
        $certificate = Certificate::create([
            'complaint_id' => $request->complaint_id,
            'certificate_number' => $certificate_number,
            'issued_to' => $request->issued_to,
            'issue_date' => $request->issue_date,
            'due_date' => $dueDateFormatted,
            'no_of_pc' => $request->no_of_pc,
            'serial_no' => $request->serial_no,
            'notes' => $request->notes,
            'hy_test' => $request->hy_test ?? '',
        ]);

        // update complaint
        Compalin::where('id', $request->complaint_id)
            ->update(['is_certificate_generate' => 1]);


        // -----------------------------
        // RENDER HTML
        // -----------------------------
        $html = view('certificate', [
            'certificate_number' => $certificate_number,
            'issued_to' => $certificate->issued_to,
            'issue_date' => $certificate->issue_date,
            'no_of_pc' => $certificate->no_of_pc,
            'serial_no' => $certificate->serial_no,
            'notes' => $certificate->notes,
            'dueDate' => $dueDateFormatted,
            'hy_test' => $request->hy_test ?? '----',
        ])->render();

        if (empty(trim($html))) {
            throw new \Exception('Certificate HTML is empty');
        }

        // -----------------------------
        // PDF PATH
        // -----------------------------
        $pdfFileName = str_replace('/', '-', $certificate_number) . '.pdf';

        $absolutePdfPath = storage_path('app/public/certificates/' . $pdfFileName);

        if (!file_exists(dirname($absolutePdfPath))) {
            mkdir(dirname($absolutePdfPath), 0755, true);
        }

        // -----------------------------
        // TEMP HTML FILE
        // -----------------------------
        $tempHtmlPath = storage_path('app/temp_' . uniqid() . '.html');
        file_put_contents($tempHtmlPath, $html);

        // -----------------------------
        // WEASYPRINT PATH
        // -----------------------------
        //for local
        // $python = 'C:\Users\Devam Joshi\AppData\Local\Programs\Python\Python313\python.exe';

        // for live
        $python = '/usr/local/bin/weasyprint';

        // base URL for images
        $baseUrl = public_path();

        // -----------------------------
        // GENERATE PDF
        // -----------------------------
        $cmd = "\"$python\" -m weasyprint --optimize-images -j 70 -D 500 --base-url \"$baseUrl\" \"$tempHtmlPath\" \"$absolutePdfPath\" 2>&1";
        $output = shell_exec($cmd);

        // save log
        file_put_contents(storage_path('logs/weasyprint.log'), $output);

        // remove temp file
        @unlink($tempHtmlPath);

        // -----------------------------
        // ERROR CHECK
        // -----------------------------
        if (!file_exists($absolutePdfPath)) {
            return response()->json([
                'error' => 'PDF generation failed',
                'log' => $output
            ]);
        }

        // Save pdf name
        $certificate->update([
            'pdf_name' => $pdfFileName
        ]);

        // -----------------------------
        // RETURN DOWNLOAD URL
        // -----------------------------
        return response()->json([
            'status' => 'success',
            'certificate_id' => $certificate->id,
            'certificate_number' => $certificate_number,
            'download_url' => asset('storage/certificates/' . $pdfFileName)
        ]);
    }

    public function downloadCertificate(Request $request)
    {
        $certificate = Certificate::where('complaint_id', $request->complaint_id)->first();

        if (!$certificate) {
            return response()->json([
                'status' => false,
                'message' => 'Certificate not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'pdf_url' => asset('storage/certificates/' . $certificate->pdf_name)
        ]);
    }
}
