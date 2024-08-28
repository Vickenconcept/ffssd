<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use Exception;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::all();
        return response()->json($tags);
    }


    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => 'required|string',
            ]);


            $tag = Tag::create($data);
            return response()->json($tag, 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            Log::error('Failed to create tag: ' . $e->getMessage());
            return response()->json([
                'message' => 'Failed to create tag.',
                'error' => 'An unexpected error occurred.',
            ], 500);
        }
    }



    public function update(Request $request, Tag $tag)
    {
        try {
            $data = $request->validate([
                'name' => 'required|string',
            ]);

            $tag->update($data);
            return response()->json($tag);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            Log::error('Failed to update tag: ' . $e->getMessage());
            return response()->json([
                'message' => 'Failed to update tag.',
                'error' => 'An unexpected error occurred.',
            ], 500);
        }
    }



    public function destroy(Tag $tag)
    {
        $tag->delete();
        return response()->json(['message' => 'Tag deleted']);
    }
}
