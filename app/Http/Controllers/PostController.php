<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function getPost(Request $request)
    {
        $id = $request->query('id');

        // Fetch the post by its ID and return it as JSON
        $post = Post::find($id);

        return response()->json($post);
    }

    public function create()
    {
        return view('post.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        $post = new Post;
        $post->title = $request->title;
        $post->body = $request->body;
        $post->save();
        return redirect('/post');
    }
    public function show($id)
    {
        // $post = Post::find($id);
        // return view('post.show', ['post' => $post]);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);
        // $post = Post::find($id);
        // $post->title = $request->title;
        // $post->body = $request->body;
        // $post->save();
        return redirect('/post');
    }
}
