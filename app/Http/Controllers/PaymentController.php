<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;

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

        $payment = Payment::create([
            'complaint_id'    => $request->complaint_id,
            'amount'          => $request->amount,
            'payment_date'    => $request->payment_date,
            'payment_made_by' => $request->payment_made_by,
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Payment created successfully',
            'data'    => $payment
        ]);
    }
}