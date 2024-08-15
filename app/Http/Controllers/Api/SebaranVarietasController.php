<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SebaranVarietas;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\SebaranVarietasRequest;

class SebaranVarietasController extends Controller
{
    // Get All Sebaran
    public function index()
    {
        $sebaran = SebaranVarietas::with('user')->latest()->get();

        return response()->json([
            'status' => 'success',
            'sebaranVarietas' => $sebaran,
        ], 200);
    }

    // Add Post SebaranVarietas
    public function store(SebaranVarietasRequest $request)
    {
        try {
            $validatedData = $request->validated();

            // Penanganan gambar yang diunggah
            if ($request->hasFile('gambar')) {
                $imageVarietas = $request->file('gambar')->store('sebaran_varietas_images', 'public');
                $validatedData['gambar'] = $imageVarietas;
            } else {
                $validatedData['gambar'] = 'path/to/default_image.jpg';
            }

            $validatedData['lat'] = $request->lat;
            $validatedData['lon'] = $request->lon;
            $validatedData['menjual_bibit'] = filter_var($request->menjual_bibit, FILTER_VALIDATE_BOOLEAN) ? 1 : 0;

            $sebaranVarietas = auth()->user()->SebaranVarietas()->create($validatedData);

            return response([
                'status' => 'success',
                'message' => 'SebaranVarietas created successfully',
                'sebaranVarietas' => $sebaranVarietas,
            ], 201);

        } catch (\Exception $e) {
            // Penanganan Error
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan ' . $e->getMessage()
            ], 500);
        }
    }
}
