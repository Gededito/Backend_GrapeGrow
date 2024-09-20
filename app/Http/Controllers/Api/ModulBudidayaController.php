<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CategoryClass;

class ModulBudidayaController extends Controller
{
    public function index(Request $request)
    {
        $modulBudidaya = CategoryClass::when($request->id, function($request, $id) {
            return $request->where('id', $id);
        })->get();

        return response()->json([
            'status' => 'success',
            'modulBudidaya' => $modulBudidaya,
        ]);
    }

    public function getVideoModul($id)
    {
        try {
            $category = CategoryClass::with('videos')->find($id);

            if (!$category) {
                return response()->json([
                    'message' => 'Kategori Modul Tidak Ditemukan',
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'modulBudidaya' => $category
            ]);
        } catch (Exception $e) {
            Log::error('Error retrieving video_modul: ' . $e->$classVideo());

            return response()->json([
                'error' => 'Error retrieving comments',
                'message' => 'An error occurred while fetching comments',
            ], 500);
        }
    }
}
