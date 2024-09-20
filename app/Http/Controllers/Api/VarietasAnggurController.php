<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\VarietasAnggur;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class VarietasAnggurController extends Controller
{
    public function index(Request $request)
    {
        $varietas = VarietasAnggur::when($request->id, function($request, $id) {
            return $request->where('id', $id);
        })->get();

        return response()->json([
            'status' => 'success',
            'data' => $varietas,
        ]);
    }

    public function getById(Request $request, $id)
    {
        try {
            $varietas = VarietasAnggur::findOrFail($id);

            return response()->json([
                'status' => 'success',
                'data' => $varietas,
            ]);
        } catch(ModelNotFoundException $e)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Data varietas tidak ditemukan'
            ], 404);
        }
    }
}
