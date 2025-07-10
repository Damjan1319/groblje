<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function importData(Request $request)
    {
        try {
            // Pokreni import komandu
            $exitCode = Artisan::call('data:import', ['--force' => true]);
            
            if ($exitCode === 0) {
                return response()->json([
                    'success' => true,
                    'message' => 'Podaci su uspešno importovani!'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Greška prilikom import-a podataka'
                ], 500);
            }
            
        } catch (\Exception $e) {
            Log::error('Import error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Greška prilikom import-a: ' . $e->getMessage()
            ], 500);
        }
    }
} 