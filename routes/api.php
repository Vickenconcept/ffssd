<?php

use App\Http\Controllers\AdminDashboardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CompanyInfoController;
use App\Http\Controllers\ContactFormController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\NavigationItemController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\SocialMediaController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;





Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::get('users', [UserController::class, 'index'])->middleware('auth:sanctum');


// Company Information
Route::get('/company-info', [CompanyInfoController::class, 'index']);
Route::post('/company-info', [CompanyInfoController::class, 'update'])->middleware('auth:sanctum');

// Navigation Items
Route::get('/navigation-items', [NavigationItemController::class, 'index']);
Route::post('/navigation-items', [NavigationItemController::class, 'store'])->middleware('auth:sanctum');
Route::put('/navigation-items/{navigationItem}', [NavigationItemController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/navigation-items/{navigationItem}', [NavigationItemController::class, 'destroy'])->middleware('auth:sanctum');

// Sections
Route::get('/sections', [SectionController::class, 'index']);
Route::post('/sections', [SectionController::class, 'store'])->middleware('auth:sanctum');
Route::put('/sections/{section}', [SectionController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/sections/{section}', [SectionController::class, 'destroy'])->middleware('auth:sanctum');

// Social Media Links
Route::get('/social-media', [SocialMediaController::class, 'index']);
Route::post('/social-media', [SocialMediaController::class, 'store'])->middleware('auth:sanctum');
Route::put('/social-media/{socialMedia}', [SocialMediaController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/social-media/{socialMedia}', [SocialMediaController::class, 'destroy'])->middleware('auth:sanctum');

// Blog Posts
Route::get('/posts', [PostController::class, 'index']);
Route::get('/posts/{post}', [PostController::class, 'show']);
Route::post('posts', [PostController::class, 'store']);
Route::put('/posts/{post}', [PostController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/posts/{post}', [PostController::class, 'destroy'])->middleware('auth:sanctum');

// Tags
Route::get('/tags', [TagController::class, 'index']);
Route::post('/tags', [TagController::class, 'store'])->middleware('auth:sanctum');
Route::put('/tags/{tag}', [TagController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/tags/{tag}', [TagController::class, 'destroy'])->middleware('auth:sanctum');

// Comments
Route::get('/posts/{post}/comments', [CommentController::class, 'index']);
Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->middleware('throttle:comment');
Route::put('/comments/{comment}', [CommentController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->middleware('auth:sanctum');
Route::patch('/comments/{id}/approve', [CommentController::class, 'approve'])->middleware('auth:sanctum');

// Contact Us Form
Route::post('/contact-us', [ContactFormController::class, 'submit']);

// Admin Dashboard
Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->middleware('auth:sanctum');

