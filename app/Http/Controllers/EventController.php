<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $now = now();
        $sixtyDaysAgo = now()->subDays(60);
        
        $events = Event::where(function($query) use ($now, $sixtyDaysAgo) {
            // Include all future events
            $query->where('date', '>=', $now)
                  // OR include past events only if within 60 days
                  ->orWhere(function($q) use ($now, $sixtyDaysAgo) {
                      $q->where('date', '<', $now)
                        ->where('date', '>=', $sixtyDaysAgo);
                  });
        })
        ->orderBy('date', 'asc')
        ->get();
        
        return response()->json($events);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'required|string',
            'location' => 'required|string',
            'description' => 'required|string',
            'type' => 'required|string',
            'registration_required' => 'boolean',
            'max_participants' => 'nullable|integer',
            'current_participants' => 'nullable|integer',
            'registration_deadline' => 'nullable|date',
            'cost' => 'nullable|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,avif|max:5120',
            'image_url' => 'nullable|string',
            'payment_url' => 'nullable|string'
        ]);

        // Handle image upload
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('event_images', $filename, 'public');
            $validated['image_url'] = '/storage/' . $path;
        }
        
        unset($validated['image']);

        $event = Event::create($validated);
        
        return response()->json([
            'message' => 'Event created successfully',
            'event' => $event
        ], 201);
    }

    public function show(Event $event)
    {
        return response()->json($event);
    }

    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => 'string|max:255',
            'date' => 'date',
            'time' => 'string',
            'location' => 'string',
            'description' => 'string',
            'type' => 'string',
            'registration_required' => 'boolean',
            'max_participants' => 'nullable|integer',
            'current_participants' => 'nullable|integer',
            'registration_deadline' => 'nullable|date',
            'cost' => 'nullable|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,avif|max:5120',
            'image_url' => 'nullable|string',
            'payment_url' => 'nullable|string'
        ]);

        // Handle image upload
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            // Delete old image if exists
            if ($event->image_url && strpos($event->image_url, '/storage/') === 0) {
                $oldPath = str_replace('/storage/', '', $event->image_url);
                \Storage::disk('public')->delete($oldPath);
            }
            
            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('event_images', $filename, 'public');
            $validated['image_url'] = '/storage/' . $path;
        }
        
        unset($validated['image']);

        $event->update($validated);
        
        return response()->json([
            'message' => 'Event updated successfully',
            'event' => $event
        ]);
    }

    public function destroy(Event $event)
    {
        $event->delete();
        
        return response()->json([
            'message' => 'Event deleted successfully'
        ], 200);
    }
}
