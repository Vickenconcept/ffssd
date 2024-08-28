<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Logic to fetch dashboard data (e.g., statistics, recent posts, etc.)
        $data = [
            'posts_count' => \App\Models\Post::count(),
            'comments_count' => \App\Models\Comment::count(),
            'sections_count' => \App\Models\Section::count(),
            // Add more data as needed
        ];

        return response()->json($data);
    }
}
