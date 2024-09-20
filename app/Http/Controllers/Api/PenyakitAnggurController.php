<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PenyakitAnggur;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PenyakitAnggurController extends Controller
{
    public function index(Request $request)
    {
        $penyakitAnggur = PenyakitAnggur::when($request->id, function($request, $id) {
            return $request->where('id', $id);
        })->get();

        return response()->json([
            'status' => 'success',
            'penyakitAnggur' => $penyakitAnggur,
        ]);
    }

    public function getById(Request $request, $id)
    {
        try {
            $penyakitAnggur = PenyakitAnggur::findOrFail($id);

            return response()->json([
                'status' => 'success',
                'penyakitAnggur' => $penyakitAnggur,
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data Penyakit Dan Hama Anggur Tidak Ditemukan',
            ], 404);
        }
    }
}
