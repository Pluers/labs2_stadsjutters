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
        return view('posts.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required',
            'image' => 'required|image',
            'condition' => 'required',
        ]);

        try {
            $post = new Post;
            $post->title = $request->title;
            $post->body = $request->body;
            $post->condition = $request->condition;
            $post->tags = $request->tags ?? null; // Assign tags if provided, otherwise set to null
            $post->user_id = auth()->id(); // Get the ID of the currently authenticated user

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $hash = hash_file('sha256', $file->getRealPath());
                $extension = $file->getClientOriginalExtension();
                $imageName = "{$hash}.{$extension}";
                $file->storeAs('public/images', $imageName);
                $post->image = asset("storage/images/{$imageName}");
            }

            $post->save();

            return response()->json(['message' => 'Post created successfully.', 'post_id' => $post->id]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function show($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return response()->json(['error' => 'Post not found'], 404);
        }

        return response()->json($post);
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
