<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->role === 'admin' || $this->ticket->event->created_by === auth()->id();
    }

    public function rules(): array
    {
        return [
            'type' => ['sometimes', Rule::in(['VIP', 'Standard', 'Economy'])],
            'price' => ['sometimes', 'numeric', 'min:0'],
            'quantity' => ['sometimes', 'integer', 'min:1'],
        ];
    }
}