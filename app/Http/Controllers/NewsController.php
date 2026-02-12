<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::with(['author:id,email', 'author.person:id,user_id,first_name,last_name'])
            ->orderBy('created_at', 'desc')
            ->get();
        return response()->json($news);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:news,slug',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'author_id' => 'nullable|exists:users,id',
            'category' => 'nullable|string',
            'tags' => 'nullable|array',
            'featured' => 'nullable|boolean',
            'status' => 'nullable|string',
            'read_time' => 'nullable|integer'
        ]);

        $news = News::create($validated);
        $news->load(['author:id,email', 'author.person:id,user_id,first_name,last_name']);
        
        return response()->json([
            'message' => 'News created successfully',
            'news' => $news
        ], 201);
    }

    public function show(News $news)
    {
        $news->load(['author:id,email', 'author.person:id,user_id,first_name,last_name']);
        return response()->json($news);
    }

    public function update(Request $request, News $news)
    {
        $validated = $request->validate([
            'title' => 'string|max:255',
            'slug' => 'string|unique:news,slug,' . $news->id,
            'excerpt' => 'nullable|string',
            'content' => 'string',
            'author_id' => 'nullable|exists:users,id',
            'category' => 'nullable|string',
            'tags' => 'nullable|array',
            'featured' => 'nullable|boolean',
            'status' => 'nullable|string',
            'read_time' => 'nullable|integer'
        ]);

        $news->update($validated);
        $news->load(['author:id,email', 'author.person:id,user_id,first_name,last_name']);
        
        return response()->json([
            'message' => 'News updated successfully',
            'news' => $news
        ]);
    }

    public function destroy(News $news)
    {
        $news->delete();
        
        return response()->json([
            'message' => 'News deleted successfully'
        ], 200);
    }

    public function publish($id)
    {
        $news = News::find($id);
        
        if (!$news) {
            return response()->json([
                'message' => 'Article not found'
            ], 404);
        }
        
        $news->update(['status' => 'published']);
        $news->load(['author:id,name,email', 'author.person:id,user_id,first_name,last_name']);
        
        return response()->json([
            'message' => 'News published successfully',
            'news' => $news
        ], 200);
    }
}
