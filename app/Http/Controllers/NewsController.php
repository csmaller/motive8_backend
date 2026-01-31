<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        return response()->json(News::all());
    }

    public function store(Request $request)
    {
        $news = News::create($request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'author_id' => 'required|integer'
        ]));
        
        return response()->json($news, 201);
    }

    public function show(News $news)
    {
        return response()->json($news);
    }

    public function update(Request $request, News $news)
    {
        $news->update($request->validate([
            'title' => 'string|max:255',
            'content' => 'string',
            'author_id' => 'integer'
        ]));
        
        return response()->json($news);
    }

    public function destroy(News $news)
    {
        $news->delete();
        return response()->json(null, 204);
    }
}
