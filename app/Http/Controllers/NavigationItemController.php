<?php

namespace App\Http\Controllers;

use App\Models\NavigationItem;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use Exception;

class NavigationItemController extends Controller
{
    public function index()
    {
        $navigationItems = NavigationItem::all();
        return response()->json($navigationItems);
    }


    public function store(Request $request)
    {
        try {
            // Validate the request data
            $data = $request->validate([
                'name' => 'required|string',
                'url' => 'required|string',
            ]);

            // Create a new NavigationItem
            $navigationItem = NavigationItem::create($data);

            return response()->json($navigationItem, 201); // 201 Created status code

        } catch (ValidationException $e) {
            // Handle validation errors
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            // Handle general exceptions (e.g., database errors)
            Log::error('Failed to create navigation item: ' . $e->getMessage());
            return response()->json([
                'message' => 'Failed to create navigation item.',
                'error' => 'An unexpected error occurred.',
            ], 500);
        }
    }

    public function update(Request $request, NavigationItem $navigationItem)
    {
        try {
            // Validate the request data
            $data = $request->validate([
                'name' => 'required|string',
                'url' => 'required|string',
            ]);

            // Update the NavigationItem
            $navigationItem->update($data);

            return response()->json($navigationItem);
        } catch (ValidationException $e) {
            // Handle validation errors
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            // Handle general exceptions (e.g., database errors)
            Log::error('Failed to update navigation item: ' . $e->getMessage());
            return response()->json([
                'message' => 'Failed to update navigation item.',
                'error' => 'An unexpected error occurred.',
            ], 500);
        }
    }


    public function destroy(NavigationItem $navigationItem)
    {
        $navigationItem->delete();
        return response()->json(['message' => 'Navigation item deleted']);
    }
}
