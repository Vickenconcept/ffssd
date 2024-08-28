<?php

namespace App\Http\Controllers;

use App\Models\CompanyInfo;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use Exception;

class CompanyInfoController extends Controller
{
    public function index()
    {
        $companyInfo = CompanyInfo::first();
        return response()->json($companyInfo);
    }


    public function update(Request $request)
    {
        try {
            $data = $request->validate([
                'address' => 'required|string',
                'phone' => 'required|string',
                'email' => 'required|string|email',
            ]);

            $companyInfo = CompanyInfo::first();
            if ($companyInfo) {
                $companyInfo->update($data);
            } else {
                $companyInfo = CompanyInfo::create($data);
            }

            return response()->json($companyInfo);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            Log::error('Failed to update company info: ' . $e->getMessage());
            return response()->json([
                'message' => 'Failed to update company info.',
                'error' => 'An unexpected error occurred.',
            ], 500);
        }
    }
}
