<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SebaranHama;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\SebaranHamaRequest;

class SebaranHamaController extends Controller
{
    // Get All Sebaran
    public function index()
    {
        $sebaran = SebaranHama::with('user')->latest()->get();

        return response()->json([
            'status' => 'success',
            'sebaranHama' => $sebaran,
        ], 200);
    }

    // Add Post SebaranHama
    public function store(SebaranHamaRequest $request)
    {
        try {
            $validatedData = $request->validated();

            // Penanganan gambar yang diunggah (sama seperti sebelumnya)
            if ($request->hasFile('gambar')) {
                $imageHama = $request->file('gambar')->store('sebaran_hama_images', 'public');
                $validatedData['gambar'] = $imageHama;
            } else {
                $validatedData['gambar'] = 'path/to/default_image.jpg'; // atau null
            }

            $validatedData['lat'] = $request->lat;
            $validatedData['lon'] = $request->lon;

            // Asosiasi dengan pengguna terautentikasi (sama seperti sebelumnya)
            $sebaran = auth()->user()->sebaranHama()->create($validatedData);

            return response()->json([
                'status' => 'success',
                'message' => 'Sebaran hama berhasil dibuat',
                'sebaranHama' => $sebaran,
            ], 201);

        } catch (\Exception $e) {
            // Penanganan error
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(), // Pesan error yang lebih informatif
            ], 500); // Status code 500 untuk internal server error
        }
    }
}
