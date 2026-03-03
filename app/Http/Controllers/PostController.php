<?php

namespace App\Http\Controllers;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
{
    $posts = Post::where('is_published', true)->orderBy('created_at', 'desc')->paginate(9);
    return view('news.index', compact('posts'));
}

public function show($id)
{
    $post = Post::findOrFail($id);
    // Gợi ý thêm các bài khác
    $related_posts = Post::where('id', '!=', $id)->limit(3)->get();
    
    return view('news.show', compact('post', 'related_posts'));
}
    //
}
