<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function index()
    {
        return response()->json([
            'message' => 'Welcome to Motive8 Backend API',
            'version' => '1.0.0'
        ]);
    }

    public function getData()
    {
        return response()->json([
            'data' => [
                'id' => 1,
                'name' => 'Sample Data',
                'created_at' => now()
            ]
        ]);
    }
}
