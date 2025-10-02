<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePaymentRequest;
use App\Models\Booking;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function store(StorePaymentRequest $request)
    {
        $booking = Booking::findOrFail($request->route('id'));
        $payment = $this->paymentService->processPayment($booking);

        return response()->json(['data' => $payment, 'message' => 'Payment processed'], 201);
    }

    public function show(Payment $payment)
    {
        if ($payment->booking->user_id !== auth()->id() && auth()->user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json(['data' => $payment], 200);
    }
}