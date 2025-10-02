<?php

namespace App\Http\Requests;

use App\Models\Booking;
use Illuminate\Foundation\Http\FormRequest;

class StorePaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        $booking = Booking::findOrFail($this->route('id'));
        return auth()->user()->role === 'customer' && $booking->user_id === auth()->id();
    }

    public function rules(): array
    {
        return [];
    }
}