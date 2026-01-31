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
            'email' => 'nullable|email|unique:person',
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string',
            'specialization' => 'nullable|string|max:255',
            'experience_years' => 'nullable|integer',
            'certification' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('person_images', 'public');
        }

        $person = Person::create($validated);
        return response()->json($person, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Person $person)
    {
        return response()->json($person->load('user', 'specializations'));
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
        $validated = $request->validate([
            'user_id' => 'sometimes|exists:users,id',
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:person,email,' . $person->id,
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string',
            'specialization' => 'nullable|string|max:255',
            'experience_years' => 'nullable|integer',
            'certification' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // remove old image if exists
            if ($person->image) {
                Storage::disk('public')->delete($person->image);
            }

            $validated['image'] = $request->file('image')->store('person_images', 'public');
        }

        $person->update($validated);
        return response()->json($person);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Person $person)
    {
        $person->delete();
        return response()->json(null, 204);
    }
}
