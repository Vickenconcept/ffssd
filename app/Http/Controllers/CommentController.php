<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;
use Exception;
use Illuminate\Support\Facades\Http;

class CommentController extends Controller
{
    public function index(Post $post)
    {
        $comments = $post->comments()->get();
        return response()->json($comments);
    }



    public function store(Request $request, Post $post)
    {
        try {
            // Validate the request data
            $data = $request->validate([
                'author' => 'required|string',
                'content' => 'required|string',
                'honeypot' => 'nullable|string',
            ]);

            // Check for honeypot field to prevent bot submissions
            if (!empty($data['honeypot'])) {
                return response()->json(['error' => 'Bot detected'], 422);
            }

            // Create the comment
            $comment = $post->comments()->create($data);
            return response()->json($comment);
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

    public function update(Request $request, Comment $comment)
    {
        try {
            // Validate the request data
            $data = $request->validate([
                'author' => 'required|string',
                'content' => 'required|string',
            ]);

            // Update the comment
            $comment->update($data);
            return response()->json($comment);
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

    public function approve($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->approved = true;
        $comment->save();

        return response()->json(['message' => 'Comment approved successfully', 'comment' => $comment]);
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();
        return response()->json(['message' => 'Comment deleted']);
    }
}
