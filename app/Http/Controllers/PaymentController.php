<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Compalin;
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

         // Get complaint
        $complaint = Compalin::find($request->complaint_id);
         // Check if payment already generated
        if ($complaint->is_payment_created == 1) {
            return response()->json([
                'status' => 'error',
                'message' => 'Payment already generated for this complaint'
            ], 400);
        }

        $payment = Payment::create([
            'complaint_id'    => $request->complaint_id,
            'amount'          => $request->amount,
            'payment_date'    => $request->payment_date,
            'payment_made_by' => $request->payment_made_by,
        ]);

        // Update complaint field
        Compalin::where('id', $request->complaint_id)
            ->update(['is_payment_created' => 1]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Payment created successfully',
            'data'    => $payment
        ]);
    }
}