<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        return response()->json(Blog::all());
    }

    public function store(Request $request)
    {
        $blog = Blog::create($request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'author_id' => 'required|integer'
        ]));
        
        return response()->json($blog, 201);
    }

    public function show(Blog $blog)
    {
        return response()->json($blog);
    }

    public function update(Request $request, Blog $blog)
    {
        $blog->update($request->validate([
            'title' => 'string|max:255',
            'content' => 'string',
            'author_id' => 'integer'
        ]));
        
        return response()->json($blog);
    }

    public function destroy(Blog $blog)
    {
        $blog->delete();
        return response()->json(null, 204);
    }
}
