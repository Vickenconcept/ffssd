<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;
use Exception;

class PostController extends Controller
{

    public function index()
    {
        $posts = Post::with('tags', 'comments', 'author')->get();

        foreach ($posts as $post) {
            if ($post->featured_image) {
                $post->featured_image_url = asset('storage/' . $post->featured_image);
            }
        }

        return response()->json($posts);
    }

    public function show(Post $post)
    {
        if ($post->featured_image) {
            $post->featured_image_url = asset('storage/' . $post->featured_image);
        }

        return response()->json($post);
    }




    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'title' => 'required|string',
                'content' => 'required|string',
                'excerpt' => 'required|string',
                'featured_image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
                'author_id' => 'required|exists:users,id',
                'publish_date' => 'nullable|date',
                'meta_description' => 'required|string',
                'cta_text' => 'nullable|string',
                'cta_url' => 'nullable|string',
            ]);

            if ($request->hasFile('featured_image')) {
                $path = $request->file('featured_image')->store('posts');
                $data['featured_image'] = $path;
            }

            $post = Post::create($data);

            if ($request->has('tags')) {
                $post->tags()->sync($request->input('tags'));
            }

            return response()->json($post);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $e->errors(),
            ], 422);
        }
    }

    public function update(Request $request, Post $post)
    {
        try {
            // Validate the request data
            $data = $request->validate([
                'title' => 'required|string',
                'content' => 'required|string',
                'excerpt' => 'required|string',
                'featured_image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
                'author_id' => 'required|exists:users,id',
                'publish_date' => 'nullable|date',
                'meta_description' => 'required|string',
                'cta_text' => 'nullable|string',
                'cta_url' => 'nullable|string',
            ]);

            // Handle the featured image upload
            if ($request->hasFile('featured_image')) {
                // Delete the old image if it exists
                if ($post->featured_image && Storage::exists($post->featured_image)) {
                    Storage::delete($post->featured_image);
                }

                // Store the new image
                $path = $request->file('featured_image')->store('posts');

                // Update the image path in the data array
                $data['featured_image'] = $path;
            }

            // Update the post with the validated data
            $post->update($data);

            // Sync tags if provided
            if ($request->has('tags')) {
                $post->tags()->sync($request->input('tags'));
            }

            // Return the updated post
            return response()->json($post);
        } catch (ValidationException $e) {
            // Handle validation errors
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $e->errors(),
            ], 422);
        } catch (QueryException $e) {
            // Handle database-related errors
            return response()->json([
                'message' => 'Database error.',
                'error' => $e->getMessage(),
            ], 500);
        } catch (Exception $e) {
            // Handle any other exceptions
            return response()->json([
                'message' => 'An unexpected error occurred.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }



    public function destroy(Post $post)
    {
        $post->delete();
        return response()->json(['message' => 'Post deleted']);
    }
}
