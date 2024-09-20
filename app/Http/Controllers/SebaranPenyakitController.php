<?php

namespace App\Http\Controllers;

use App\Models\SebaranPenyakit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SebaranPenyakitController extends Controller
{
    public function index(Request $request)
    {
        $sebaranPenyakit = DB::table('sebaran_penyakits')
        ->when($request->input('nama'), function($query, $nama){
            return $query->where('nama', 'like', '%'.$nama.'%');
        })
        ->orderBy('id', 'desc')
        ->paginate(100);

        return view('pages.sebaran_penyakit.index', compact('sebaranPenyakit'));
    }

    public function destroy($id)
    {
        $sebaranPenyakit = SebaranPenyakit::findOrFail($id);
        $sebaranPenyakit->delete();

        return redirect()->route('sebaran_penyakit.index')->with('success', 'Sebaran Penyakit successfully deleted');
    }
}
