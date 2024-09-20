<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SebaranVarietas;
use Illuminate\Support\Facades\Auth;
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

    public function update($id, UpdateSebaranVarietas $request)
    {
        try {
            $sebaranVarietas = SebaranVarietas::findOrFail($id);

            if ($sebaranVarietas->user_id !== auth()->user()->id) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Anda tidak memiliki akses',
                ], 403);
            }

            $validatedData = $request->validated();

            if ($request->hasFile('gambar')) {
                if ($sebaranVarietas->gambar && Storage::disk('public')->exists($sebaranVarietas->gambar)) {
                    Storage::disk('public')->delete($sebaranVarietas->gambar);
                }

                $imageVarietas = $request->file('gambar')->store('sebaran_varietas', 'public');
                $validatedData['gambar'] = $imageVarietas;
            }

            $validatedData['lat'] = $request->lat;
            $validatedData['lon'] = $request->lon;

            $sebaranVarietas->update($validatedData);

            return response([
                'status' => 'success',
                'message' => 'Sebaran Varietas Berhasil Diperbarui',
                'sebaranVarietas' => $sebaranVarietas
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan ' . $e->getMessage()
            ], 500);
        }
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
