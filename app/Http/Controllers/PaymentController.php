<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Compalin;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\User;


class PaymentController extends Controller
{
    public function createPayment(Request $request)
{
    $request->validate([
        'complaint_id'    => 'required|exists:complains,id',
        'amount'          => 'required|numeric',
        'payment_date'    => 'required|date',
        'payment_made_by' => 'required|string',
    ]);

    // Get complaint
    $complaint = Compalin::find($request->complaint_id);

    // Check if payment already generated
    if ($complaint->is_payment_created == 1) {
        return response()->json([
            'status'  => 'error',
            'message' => 'Payment already generated for this complaint'
        ], 400);
    }

    // Create payment record
    $payment = Payment::create([
        'complaint_id'    => $request->complaint_id,
        'amount'          => $request->amount,
        'payment_date'    => $request->payment_date,
        'payment_made_by' => $request->payment_made_by,
    ]);

    // Update complaint field
    Compalin::where('id', $request->complaint_id)
        ->update(['is_payment_created' => 1]);

    // -----------------------------
    // RENDER HTML
    // -----------------------------
    // $html = view('report', [
    //     'complaint'    => $complaint,
    //     'payment'      => $payment,
    //    'payment_date' => \Carbon\Carbon::parse($request->payment_date)->format('d-m-Y'),
    // ])->render();

    $html = view('report', [
    'payment'   => $payment,                          // Payment model
    'complaint' => Compalin::find($payment->complaint_id),
    'user'      => User::find($complaint->user_id),
])->render();


    if (empty(trim($html))) {
        throw new \Exception('Payment receipt HTML is empty');
    }

    // -----------------------------
    // PDF PATH
    // -----------------------------
    $pdfFileName = 'payment-' . $payment->id . '-complaint-' . $request->complaint_id . '.pdf';

    $absolutePdfPath = storage_path('app/public/payments/' . $pdfFileName);

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
    // for local (Windows)
    // $python = 'C:\Users\Devam Joshi\AppData\Local\Programs\Python\Python313\python.exe';

    // for live
    // $python = '/usr/local/bin/weasyprint';

    // for local (Mac)
    $python = '/Users/riddhithanki/weasy-env/bin/weasyprint';

    // base URL for images
    $baseUrl = public_path();

    // -----------------------------
    // GENERATE PDF
    // -----------------------------
    $cmd = "\"$python\" \"$tempHtmlPath\" \"$absolutePdfPath\" --base-url \"$baseUrl\" 2>&1";
    $output = shell_exec($cmd);

    // Save log
    file_put_contents(storage_path('logs/weasyprint.log'), $output);

    // Remove temp HTML file
    @unlink($tempHtmlPath);

    // -----------------------------
    // ERROR CHECK
    // -----------------------------
    if (!file_exists($absolutePdfPath)) {
        return response()->json([
            'status' => 'error',
            'message' => 'PDF generation failed',
            'log'    => $output
        ], 500);
    }

    // Save pdf name on payment record
    $payment->update([
        'pdf_name' => $pdfFileName
    ]);

    // -----------------------------
    // RETURN RESPONSE
    // -----------------------------
    return response()->json([
        'status'       => 'success',
        'message'      => 'Payment created successfully',
        'payment_id'   => $payment->id,
        'download_url' => asset('storage/payments/' . $pdfFileName),
        'data'         => $payment
    ]);
}
}
