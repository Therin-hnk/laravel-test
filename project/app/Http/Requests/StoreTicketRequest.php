<?php

namespace App\Http\Requests;

use App\Models\Event;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        $event = Event::findOrFail($this->route('event_id'));
        return auth()->user()->role === 'admin' || $event->created_by === auth()->id();
    }

    public function rules(): array
    {
        return [
            'type' => ['required', Rule::in(['VIP', 'Standard', 'Economy'])],
            'price' => ['required', 'numeric', 'min:0'],
            'quantity' => ['required', 'integer', 'min:1'],
        ];
    }
}