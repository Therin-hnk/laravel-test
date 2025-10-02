<?php

namespace App\Http\Requests;

use App\Models\Ticket;
use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->role === 'customer';
    }

    public function rules(): array
    {
        return [
            'quantity' => [
                'required',
                'integer',
                'min:1',
                function ($attribute, $value, $fail) {
                    $ticket = Ticket::findOrFail($this->route('id'));
                    if ($value > $ticket->quantity) {
                        $fail('The quantity exceeds available tickets.');
                    }
                },
            ],
        ];
    }
}