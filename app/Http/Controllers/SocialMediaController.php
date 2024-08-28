<?php

namespace App\Http\Controllers;

use App\Models\SocialMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use Exception;

class SocialMediaController extends Controller
{
    public function index()
    {
        $socialMedia = SocialMedia::all();

        foreach ($socialMedia as $media) {
            if ($media->icon) {
                $media->icon_url = asset('storage/' . $media->icon);
            }
        }

        return response()->json($socialMedia);
    }


    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => 'required|string',
                'url' => 'required|string',
                'icon' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            ]);

            if ($request->hasFile('icon')) {
                $path = $request->file('icon')->store('icons');
                $data['icon'] = $path;
            }

            $socialMedia = SocialMedia::create($data);
            return response()->json($socialMedia, 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            Log::error('Failed to create social media entry: ' . $e->getMessage());
            return response()->json([
                'message' => 'Failed to create social media entry.',
                'error' => 'An unexpected error occurred.',
            ], 500);
        }
    }


    public function update(Request $request, SocialMedia $socialMedia)
    {
        try {
            $data = $request->validate([
                'name' => 'required|string',
                'url' => 'required|string',
                'icon' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            ]);

            if ($request->hasFile('icon')) {
                $path = $request->file('icon')->store('icons'); 
                $data['icon'] = $path; 

                if ($socialMedia->icon && Storage::exists($socialMedia->icon)) {
                    Storage::delete($socialMedia->icon);
                }
            }

            $socialMedia->update($data);
            return response()->json($socialMedia);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            Log::error('Failed to update social media entry: ' . $e->getMessage());
            return response()->json([
                'message' => 'Failed to update social media entry.',
                'error' => 'An unexpected error occurred.',
            ], 500);
        }
    }



    public function destroy(SocialMedia $socialMedia)
    {
        if ($socialMedia->icon) {
            Storage::delete($socialMedia->icon);
        }

        $socialMedia->delete();
        return response()->json(['message' => 'Social media link deleted']);
    }
}
