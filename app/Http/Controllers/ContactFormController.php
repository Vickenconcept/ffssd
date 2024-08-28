<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use Exception;

class ContactFormController extends Controller

{
    public function submit(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => 'required|string',
                'email' => 'required|string|email',
                'message' => 'required|string',
            ]);

            Mail::send('emails.contact', $data, function ($message) use ($data) {
                $message->to(env('ADMIN_EMAIL'))
                    ->subject('New Contact Us Message from ' . $data['name']);
            });

            return response()->json(['message' => 'Message sent successfully']);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            Log::error('Failed to send email: ' . $e->getMessage());
            return response()->json([
                'message' => 'Failed to send message.',
                'error' => 'An unexpected error occurred.',
            ], 500);
        }
    }
}
