<?php

namespace App\Http\Controllers;

use App\Models\SebaranVarietas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SebaranVarietasController extends Controller
{
    public function index(Request $request)
    {
        $sebaranVarietas = DB::table('sebaran_varietas')
        ->when($request->input('nama'), function($query, $nama) {
            return $query->where('nama', 'like', '%'.$nama.'%');
        })
        ->paginate(100);

        return view('pages.sebaran_varietas.index', compact('sebaranVarietas'));
    }

    public function destroy($id)
    {
        $sebaranVarietas = SebaranVarietas::findOrFail($id);
        $sebaranVarietas->delete();

        return redirect()->route('sebaran_varietas.index')->with('success', 'Sebaran Varietas successfully deleted');
    }
}
