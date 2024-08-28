<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use Exception;

class SectionController extends Controller
{
    public function index()
    {
        $sections = Section::all();
        return response()->json($sections);
    }


    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'background_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', 
                'title' => 'required|string',
                'content' => 'required|string',
                'cta_text' => 'nullable|string',
                'cta_url' => 'nullable|string',
                'is_active' => 'required|boolean',
            ]);

            if ($request->hasFile('background_image')) {
                $file = $request->file('background_image');
                $filePath = $file->store('background_images', 'public'); 
                $data['background_image'] = $filePath; 
            }

            $section = Section::create($data);
            return response()->json($section, 201); 

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            Log::error('Failed to create section: ' . $e->getMessage());
            return response()->json([
                'message' => 'Failed to create section.',
                'error' => 'An unexpected error occurred.',
            ], 500);
        }
    }


    public function update(Request $request, Section $section)
    {
        try {
            $data = $request->validate([
                'background_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
                'title' => 'required|string',
                'content' => 'required|string',
                'cta_text' => 'nullable|string',
                'cta_url' => 'nullable|string',
                'is_active' => 'required|boolean',
            ]);

            if ($request->hasFile('background_image')) {
                if ($section->background_image && Storage::disk('public')->exists($section->background_image)) {
                    Storage::disk('public')->delete($section->background_image);
                }

                $file = $request->file('background_image');
                $filePath = $file->store('background_images', 'public'); 
                $data['background_image'] = $filePath; 
            }

            $section->update($data);
            return response()->json($section);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            Log::error('Failed to update section: ' . $e->getMessage());
            return response()->json([
                'message' => 'Failed to update section.',
                'error' => 'An unexpected error occurred.',
            ], 500);
        }
    }


    public function destroy(Section $section)
    {
        if ($section->background_image) {
            Storage::disk('public')->delete($section->background_image);
        }

        $section->delete();

        return response()->json(['message' => 'Section deleted']);
    }
}
