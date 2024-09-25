<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SebaranVarietas;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\SebaranVarietasRequest;
use App\Http\Requests\UpdateSebaranVarietas;

class SebaranVarietasController extends Controller
{
    public function index()
    {
        $sebaran = SebaranVarietas::with('user')->latest()->get();

        return response()->json([
            'status' => 'success',
            'sebaranVarietas' => $sebaran,
        ], 200);
    }

    public function store(SebaranVarietasRequest $request)
    {
        try {
            $validatedData = $request->validated();

            if ($request->hasFile('gambar')) {
                $imageVarietas = $request->file('gambar')->store('sebaran_varietas', 'public');
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
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan ' . $e->getMessage()
            ], 500);
        }
    }

    public function update($id, Request $request)
    {
        $sebaranVarietas = SebaranVarietas::find($id);

        if (!$sebaranVarietas) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data Tidak Ditemukan',
            ], 404);
        }

        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'gambar' => 'sometimes|image',
            'deskripsi' => 'required|string',
            'jumlah_tanaman' => 'required|integer',
            'menjual_bibit' => 'required|boolean',
            'lat' => 'required|float',
            'lon' => 'required|float',
        ]);

        if ($request->hasFile('gambar')) {
            // Hapus Gambar Lama Jika Ada
            if ($sebaranVarietas->gambar) {
                Storage::disk('public')->delete($sebaranVarietas->gambar);
            }
            $validatedData['gambar'] = $request->file('gambar')->store('sebaran_varietas', 'public');
        }

        log('Validate Data: ', $validatedData);

        $sebaranVarietas->update($validatedData);

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil Memperbarui Data',
            'sebaranVarietas' => $sebaranVarietas,
        ], 200);
    }

    public function delete($id) {
        try {
            $sebaranVarietas = SebaranVarietas::findOrFail($id);

            if ($sebaranVarietas->user_id !== auth()->user()->id) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Anda tidak memiliki akses',
                ], 403);
            }

            $sebaranVarietas->delete();

            return response([
                'status' => 'success',
                'message' => 'Sebaran Varietas Berhasil Dihapuskan',
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan ' . $e->getMessage()
            ], 500);
        }
    }
}
