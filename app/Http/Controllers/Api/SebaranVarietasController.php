<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SebaranVarietas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
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
        try {
            $data = $request->all();
            $sebaranVarietas = SebaranVarietas::findOrFail($id);

            if ($sebaranVarietas->user_id !== auth()->user()->id) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Anda Tidak Memiliki Akses',
                ], 403);
            }

            $validator = Validator::make($data, [
               'nama' => 'sometimes|string|max:255',
               'deskripsi' => 'sometimes|string',
               'jumlah_tanaman' => 'sometimes|numeric',
               'menjual_bibit' => 'sometimes|boolean',
               'lat' => 'sometimes|numeric',
               'lon' => 'sometimes|numeric',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()
                ], 403);
            }

            $sebaranVarietas->fill($request->only('nama', 'deskripsi', 'menjual_bibit', 'lat', 'lon'));
            $sebaranVarietas->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Sebaran Varietas updated successfully',
                'sebaranVarietas' => $sebaranVarietas,
            ], 200); // Ubah response code menjadi 200 OK

        } catch (\Exception $e) {
            Log::error('Error saat mengupdate data: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
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
