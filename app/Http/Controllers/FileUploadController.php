<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileUploadController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,gif,svg',
        ]);

        $path = $request->file('file')->store('uploads');

        return response()->json(['path' => $path]);
    }

    public function delete(Request $request)
    {
        $request->validate([
            'file_path' => 'required|string',
        ]);

        Storage::delete($request->input('file_path'));

        return response()->json(['message' => 'File deleted successfully']);
    }
}
