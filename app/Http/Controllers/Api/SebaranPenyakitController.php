<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SebaranPenyakit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\SebaranPenyakitRequest;
use App\Http\Requests\UpdateSebaranPenyakit;

class SebaranPenyakitController extends Controller
{
    public function index()
    {
        $sebaranPenyakit = SebaranPenyakit::with('user')->latest()->get();

        return response()->json([
            'status' => 'success',
            'sebaranPenyakit' => $sebaranPenyakit,
        ], 200);
    }

    public function store(SebaranPenyakitRequest $request)
    {
        try {
            $validatedData = $request->validated();

            if ($request->hasFile('gambar')) {
                $imagePenyakit = $request->file('gambar')->store('sebaran_penyakit', 'public');
                $validatedData['gambar'] = $imagePenyakit;
            } else {
                $validatedData['gambar'] = 'path/to/default_image.jpg';
            }

            $validatedData['lat'] = $request->lat;
            $validatedData['lon'] = $request->lon;

            $sebaranPenyakit = auth()->user()->sebaranPenyakit()->create($validatedData);

            return response([
                'status' => 'success',
                'message' => 'SebaranPenyakit created successfully',
                'sebaranPenyakit' => $sebaranPenyakit
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
            $sebaranPenyakit = SebaranPenyakit::findOrFail($id);

            if ($sebaranPenyakit->user_id !== auth()->user()->id) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Anda Tidak Memiliki Akses',
                ], 403);
            }

            $validator = Validator::make($data, [
                'nama' => 'sometimes|string|max:255',
                'gejala' => 'sometimes|string',
                'solusi' => 'sometimes|string',
                'lat' => 'sometimes|numeric',
                'lon' => 'sometimes|numeric',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()
                ], 403);
            }

            $sebaranPenyakit->fill($request->only('nama', 'gejala', 'solusi', 'lat', 'lon'));
            $sebaranPenyakit->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Sebaran Penyakit updated successfully',
                'sebaranPenyakit' => $sebaranPenyakit
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
            $sebaranPenyakit = SebaranPenyakit::findOrFail($id);

            if ($sebaranPenyakit->user_id !== auth()->user()->id) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Anda tidak memiliki akses',
                ], 403);
            }

            $sebaranPenyakit->delete();

            return response([
                'status' => 'success',
                'message' => 'Sebaran Penyakit Berhasil Dihapuskan'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan ' . $e->getMessage()
            ], 500);
        }
    }
}
