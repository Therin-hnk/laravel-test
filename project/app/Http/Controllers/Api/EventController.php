<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::query();

        // Filtres
        if ($request->has('search')) {
            $query->where('title', 'LIKE', '%' . $request->search . '%');
        }
        if ($request->has('date')) {
            $query->whereDate('date', $request->date);
        }
        if ($request->has('location')) {
            $query->where('location', 'LIKE', '%' . $request->location . '%');
        }

        $events = $query->paginate(10);

        return response()->json(['data' => $events], 200);
    }

    public function show(Event $event)
    {
        $event->load('tickets');
        return response()->json(['data' => $event], 200);
    }

    public function store(StoreEventRequest $request)
    {
        $event = Event::create([
            'title' => $request->title,
            'description' => $request->description,
            'date' => $request->date,
            'location' => $request->location,
            'created_by' => auth()->id(),
        ]);

        return response()->json(['data' => $event, 'message' => 'Event created'], 201);
    }

    public function update(UpdateEventRequest $request, Event $event)
    {
        $event->update($request->validated());
        return response()->json(['data' => $event, 'message' => 'Event updated'], 200);
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return response()->json(['message' => 'Event deleted'], 204);
    }
}