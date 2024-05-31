<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, $id)
    {
        $request->validate([
            'author' => 'required|string|mas:255',
            'content' => 'required|string'
        ]);
    
        $comment = Comment::create([
            'blog_post_id' => $postId,
            'author' => $request->author,
            'content' => $request->content,
        ]);
    
        return response()->json($comment, 201);
    }

    public function index($postId)
    {
        $comments = Comment::whare('blog_post_id', $postId)->get();
        return response()->json($comment);
    }

}
