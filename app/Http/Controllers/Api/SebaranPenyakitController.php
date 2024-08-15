<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SebaranPenyakit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\SebaranPenyakitRequest;

class SebaranPenyakitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $sebaranPenyakit = SebaranPenyakit::with('user')->latest()->get();

        return response()->json([
            'status' => 'success',
            'sebaranPenyakit' => $sebaranPenyakit,
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SebaranPenyakitRequest $request)
    {
        //
        try {

            $validatedData = $request->validated();

            // Penanganan Gambar Yang Diunggah
            if ($request->hasFile('gambar')) {
                $imagePenyakit = $request->file('gambar')->store('sebaran_penyakit', 'public');
                $validatedData['gambar'] = $imagePenyakit;
            } else {
                $validatedData['gambar'] = 'images/icon-default.png';
            }

            $validatedData['lat'] = $request->lat;
            $validatedData['lon'] = $request->lon;

            $sebaranPenyakit = auth()->user()->sebaranPenyakit()->create($validatedData);

            return response()->json([
                'status' => 'success',
                'message' => 'Sebaran Penyakit Berhasil Dibuat',
                'sebaranPenyakit' => $sebaranPenyakit,
            ], 201);

        } catch(\Exception $e) {

            // Menangani Error
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi Kesalahan: ' . $e->getMessage(),
            ]);

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(SebaranPenyakit $sebaranPenyakit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SebaranPenyakit $sebaranPenyakit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SebaranPenyakit $sebaranPenyakit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SebaranPenyakit $sebaranPenyakit)
    {
        //
    }
}
