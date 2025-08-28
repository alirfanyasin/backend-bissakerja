<?php

use Illuminate\Support\Facades\Route;
use App\Models\Disabilitas;

Route::get('/', function () {
  return "<h1>Welcome to Jatim Bissa</h1>";
});

Route::get('/test-disabilitas', function () {
    try {
        $data = Disabilitas::all();
        return response()->json([
            'success' => true,
            'total' => $data->count(),
            'data' => $data
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage()
        ]);
    }
});
