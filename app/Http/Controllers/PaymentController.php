<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'payment_via' => 'required|string',
            'receipt' => 'required',  
        ]);

         
        if ($request->hasFile('receipt')) {
            $receiptName = time() . '.' . $request->receipt->extension();
            $request->receipt->move(public_path('receipts'), $receiptName);
        }

        // Save the payment data
        Payment::create([
            'customer_id' => Auth::id(),
            'payment_via' => $request->payment_via,
            'receipt' => $receiptName,
            'status' => false, 
        ]);

        return redirect()->back()->with('success', 'Payment submitted successfully.');
    }
}
