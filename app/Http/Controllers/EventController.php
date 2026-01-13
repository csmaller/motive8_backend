<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        return response()->json(Event::all());
    }

    public function store(Request $request)
    {
        $event = Event::create($request->validate([
            'title' => 'required|string|max:45',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'start_end_time' => 'required|string|max:45',
            'details' => 'nullable|string',
            'sub_title' => 'nullable|string|max:100'
        ]));
        
        return response()->json($event, 201);
    }

    public function show(Event $event)
    {
        return response()->json($event);
    }

    public function update(Request $request, Event $event)
    {
        $event->update($request->validate([
            'title' => 'string|max:45',
            'start_date' => 'date',
            'end_date' => 'date',
            'start_end_time' => 'string|max:45',
            'details' => 'nullable|string',
            'sub_title' => 'nullable|string|max:100'
        ]));
        
        return response()->json($event);
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return response()->json(null, 204);
    }
}
