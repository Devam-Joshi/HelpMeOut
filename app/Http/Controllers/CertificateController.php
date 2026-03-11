<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use App\Models\Certificate;
use Carbon\Carbon;

class CertificateController extends Controller
{
    public function create(Request $request)
    {
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

        // -----------------------------
        // IMAGE BASE64 FUNCTION
        // -----------------------------
        function base64Image($path)
        {
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            return 'data:image/' . $type . ';base64,' . base64_encode($data);
        }

        // -----------------------------
        // IMAGES
        // -----------------------------
        $images = [
            'safety_logo' => base64Image(public_path('images/safety_first.jpg')),
            'sk_logo' => base64Image(public_path('images/sk_logo.jpeg')),
            'fire_icon' => base64Image(public_path('images/fire_extinguare.png')),
            'iso_logo' => base64Image(public_path('images/iso_9001.jpg')),
            'footer1' => base64Image(public_path('images/footer_image_1.jpg')),
            'footer2' => base64Image(public_path('images/footer_image_2.jpg')),
            'footer3' => base64Image(public_path('images/footer_image_3.jpg')),
            'footer4' => base64Image(public_path('images/footer_image_4.jpg')),
            'footer5' => base64Image(public_path('images/footer_image_5.jpg')),
            'footer6' => base64Image(public_path('images/footer_image_6.jpg')),
            'footer7' => base64Image(public_path('images/footer_image_7.jpg')),
            'footer8' => base64Image(public_path('images/footer_image_8.jpg')),
            'footer9' => base64Image(public_path('images/footer_image_9.jpg')),
        ];

        // -----------------------------
        // RENDER HTML
        // -----------------------------
        $html = view('certificate', array_merge($images, [
            'certificate_number' => $certificate_number,
            'issued_to' => $certificate->issued_to,
            'issue_date' => $certificate->issue_date,
            'no_of_pc' => $certificate->no_of_pc,
            'serial_no' => $certificate->serial_no,
            'notes' => $certificate->notes,
            'dueDate' => $dueDateFormatted,
        ]))->render();

        if (empty(trim($html))) {
            throw new \Exception('Certificate HTML is empty');
        }

        // -----------------------------
        // PDF PATH
        // -----------------------------
        $pdfFileName = 'certificate-' . $certificate->id . '.pdf';

        $absolutePdfPath = storage_path(
            'app/public/certificates/' . $pdfFileName
        );

        if (!file_exists(dirname($absolutePdfPath))) {
            mkdir(dirname($absolutePdfPath), 0755, true);
        }

        // -----------------------------
        // GENERATE PDF USING WEASYPRINT
        // -----------------------------
        $tempHtmlPath = storage_path('app/temp_' . uniqid() . '.html');
          file_put_contents($tempHtmlPath, $html);

          $weasyBin = '/usr/local/bin/weasyprint';

          if (!file_exists($weasyBin)) {
              $weasyBin = '/usr/bin/weasyprint';
          }

          $cmd = $weasyBin . ' ' . escapeshellarg($tempHtmlPath) . ' ' . escapeshellarg($absolutePdfPath) . ' 2>&1';

          $output = shell_exec($cmd);

          file_put_contents(storage_path('logs/weasyprint.log'), $output);

          @unlink($tempHtmlPath);

          if (!file_exists($absolutePdfPath)) {
              return response()->json([
                  'error' => 'PDF generation failed',
                  'log' => $output
              ]);
          }
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
}