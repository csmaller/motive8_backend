<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PersonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Person::with('user')->get());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string',
            'specialization' => 'nullable|string|max:255',
            'specializations' => 'nullable|array',
            'experience_years' => 'nullable|integer',
            'certification' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max
        ]);
        
        // Remove specializations array (handle separately if needed)
        if (isset($validated['specializations'])) {
            unset($validated['specializations']);
        }
        
        // Handle file upload
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('person_images', $filename, 'public');
            $validated['image'] = $path;
        }

        // Update user email if provided
        if (isset($validated['email'])) {
            $user = \App\Models\User::find($validated['user_id']);
            if ($user) {
                $user->update(['email' => $validated['email']]);
            }
            unset($validated['email']);
        }

        $person = Person::create($validated);
        $person->load('user');
        
        return response()->json([
            'message' => 'Person created successfully',
            'person' => $person
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Person $person)
    {
        return response()->json($person->load('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Person $person)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Person $person)
    {
        // Check if this is a multipart form request
        $isMultipart = $request->hasFile('image');
        
        $rules = [
            'user_id' => 'sometimes|exists:users,id',
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string',
            'specialization' => 'nullable|string|max:255',
            'specializations' => 'nullable|array',
            'experience_years' => 'nullable|integer',
            'certification' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ];

        // Validate email against users table if provided
        if ($request->has('email')) {
            $rules['email'] = 'nullable|email|unique:users,email,' . $person->user_id;
        }

        $validated = $request->validate($rules);

        // Remove specializations array
        if (isset($validated['specializations'])) {
            unset($validated['specializations']);
        }

        // Handle file upload
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            \Log::info('Updating image for person ' . $person->id);
            
            // Delete old image if exists
            if ($person->image && Storage::disk('public')->exists($person->image)) {
                \Log::info('Deleting old image: ' . $person->image);
                Storage::disk('public')->delete($person->image);
            }
            
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('person_images', $filename, 'public');
            $validated['image'] = $path;
            
            \Log::info('New image saved: ' . $path);
        }

        // Update user email if provided
        if (isset($validated['email'])) {
            $person->user->update(['email' => $validated['email']]);
            unset($validated['email']);
        }

        $person->update($validated);
        $person->load('user');
        
        return response()->json([
            'message' => 'Person updated successfully',
            'person' => $person
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Person $person)
    {
        $person->delete();
        return response()->json(null, 204);
    }

    /**
     * Get all coaches (people with coach user type).
     */
    public function getCoaches()
    {
        $coaches = Person::with('user')
            ->whereHas('user', function ($query) {
                $query->whereHas('userType', function ($q) {
                    $q->where('type', 'coach');
                });
            })
            ->get();

        return response()->json($coaches);
    }
}
