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

    public function getPosts(Request $request)
    {
        $posts = Post::all();

        return response()->json($posts);
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
            'image' => 'image',
            'condition' => 'required',
        ]);

        try {
            $post = Post::findOrFail($id); // This will automatically return a 404 response if the post is not found
            error_log(print_r($request->all(), true));
            $post->title = $request->title;
            $post->body = $request->body;
            $post->condition = $request->condition;
            $post->tags = $request->tags ?? $post->tags; // Update tags if provided, otherwise keep the old ones

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $hash = hash_file('sha256', $file->getRealPath());
                $extension = $file->getClientOriginalExtension();
                $imageName = "{$hash}.{$extension}";
                $file->storeAs('public/images', $imageName);
                error_log("Image stored as: public/images/{$imageName}");
                $post->image = asset("storage/images/{$imageName}");
                error_log("Image path: " . $post->image);
            }

            $post->save();
            error_log("Post saved: " . $post->id);
            return response()->json(['message' => 'Post updated successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
