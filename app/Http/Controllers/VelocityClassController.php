<?php

namespace App\Http\Controllers;

use App\Models\VelocityClass;
use Illuminate\Http\Request;

class VelocityClassController extends Controller
{
    public function index()
    {
        $classes = VelocityClass::all();
        return response()->json($classes);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'schedule' => 'required|string',
            'duration' => 'required|string',
            'max_participants' => 'nullable|integer|min:0',
            'current_enrollment' => 'nullable|integer|min:0',
            'instructor' => 'required|string',
            'level' => 'required|string',
            'cost' => 'nullable|numeric|min:0',
            'location' => 'nullable|string',
            'equipment' => 'nullable|array',
            'prerequisites' => 'nullable|array'
        ]);

        $class = VelocityClass::create($validated);
        
        return response()->json([
            'message' => 'Class created successfully',
            'class' => $class
        ], 201);
    }

    public function show(VelocityClass $velocityClass)
    {
        return response()->json($velocityClass);
    }

    public function update(Request $request, VelocityClass $velocityClass)
    {
        $validated = $request->validate([
            'name' => 'string|max:255',
            'description' => 'string',
            'schedule' => 'string',
            'duration' => 'string',
            'max_participants' => 'nullable|integer|min:0',
            'current_enrollment' => 'nullable|integer|min:0',
            'instructor' => 'string',
            'level' => 'string',
            'cost' => 'nullable|numeric|min:0',
            'location' => 'nullable|string',
            'equipment' => 'nullable|array',
            'prerequisites' => 'nullable|array'
        ]);

        $velocityClass->update($validated);
        
        return response()->json([
            'message' => 'Class updated successfully',
            'class' => $velocityClass
        ]);
    }

    public function destroy(VelocityClass $velocityClass)
    {
        $velocityClass->delete();
        
        return response()->json([
            'message' => 'Class deleted successfully'
        ], 200);
    }
}
