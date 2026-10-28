<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with('user', 'visaApplication')->latest();

        if ($request->status && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $payments = $query->paginate(12);
        return view('admin.payments.index', compact('payments'));
    }

    public function verify(Payment $payment)
    {
        $payment->update(['status' => 'verified']);
        return back()->with('success', 'Payment verified.');
    }

    public function reject(Payment $payment)
    {
        $payment->update(['status' => 'rejected']);
        return back()->with('success', 'Payment rejected.');
    }
}