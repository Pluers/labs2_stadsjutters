<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        return view('index');
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

        //// Post should be used for the model Post later
        // $post = new Post;
        // $post->title = $request->title;
        // $post->body = $request->body;
        // $post->save();
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
