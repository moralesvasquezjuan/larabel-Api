<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BlogPostController extends Controller
{
    public function index(){
        $posts = BlogPodt::all();
        return response()->json($posts);
    }
    public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'image' => 'nullable|image',
    ]);
if ($request->hasFile('image')){
    $imagePath =  $request->file('image')->store('images', 'public');
}else{
    $imagePath = null;
}

    $post = BlogPost::create([
        'title' => $request->title,
        'content' => $request->content,
        'image' => $imagePath,
    ]);

    return response()->json($post, 201);
}

public function indexPublic()
{
    $posts = BlogPost::all();
    return response()->json($posts);   
}

public function show($id)
{
$post = BlogPost::findOrFail($id);
return response()->json($post);
}

public function update(Request $request, $id)
{
    $request->validate([
        'title' => 'sometimes|required|string|max:255',
        'content' => 'sometimes|required|string',
        'image' => 'nullable|image',
    ]);

    $post = BlogPost::findOrFail($id);

    if ($request->hasFile('image')){
        $imagePath =  $request->file('image')->store('images', 'public');
        $post->image_path = $imagePath;
    }
    $post->update($request->only(['title','content']));

    return response()->json($post);
}

public function destroy($id)
{
    $post = BlogPost::findOrFail($id);
    $post->delete();
    return response()->json(null, 204);
}

}
