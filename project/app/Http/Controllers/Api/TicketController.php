<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function store(StoreTicketRequest $request)
    {
        $ticket = Ticket::create([
            'type' => $request->type,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'event_id' => $request->route('event_id'),
        ]);

        return response()->json(['data' => $ticket, 'message' => 'Ticket created'], 201);
    }

    public function update(UpdateTicketRequest $request, Ticket $ticket)
    {
        $ticket->update($request->validated());
        return response()->json(['data' => $ticket, 'message' => 'Ticket updated'], 200);
    }

    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        return response()->json(['message' => 'Ticket deleted'], 204);
    }
}