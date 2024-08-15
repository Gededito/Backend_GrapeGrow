<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HamaAnggur;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class HamaAnggurController extends Controller
{
    // Get All
    public function index(Request $request)
    {
        $hama = HamaAnggur::when($request->id, function($request, $id) {
            return $request->where('id', $id);
        })->get();

        return response()->json([
            'status' => 'success',
            'data' => $hama,
        ]);
    }

    // Get Hama By Id
    public function getById(Request $request, $id)
    {
        try {
            // Cari data berdasarkan ID
            $hama = \App\Models\HamaAnggur::findOrFail($id);

            // Jika data ditemukan
            return response()->json([
                'status' => 'success',
                'data' => $hama,
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data hama anggur tidak ditemukan',
            ], 404);
        }
    }
}
