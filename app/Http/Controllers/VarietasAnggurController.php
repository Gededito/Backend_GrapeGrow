<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VarietasAnggur;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreVarietasRequest;
use App\Http\Requests\UpdateVarietasRequest;


class VarietasAnggurController extends Controller
{
    //
    public function index(Request $request)
    {
        // $varietas = \App\Models\VarietasAnggur::paginate(10);

        $varietas = DB::table('varietas_anggurs')
        ->when($request->input('nama'), function ($query, $nama) {
            return $query->where('nama', 'like', '%'.$nama.'%');
        })
        ->orderBy('id', 'desc')
        ->paginate(100);
        return view('pages.varietas.index', compact('varietas'));
    }

    public function create()
    {
        return view('pages.varietas.create');
    }

    public function store(StoreVarietasRequest $request)
    {
        $gambarVarietas = null;
        if ($request->hasFile('gambar')) {
            $gambarVarietas = $request->file('gambar')->store('gambar_varietas', 'public');
        }

        $data = $request->all();
        $data['gambar'] = $gambarVarietas;

        VarietasAnggur::create($data);
        return redirect()->route('varietas.index')->with('success', 'Varietas successfully created');
    }

    public function edit($id)
    {
        $varietas = \App\Models\VarietasAnggur::findOrFail($id);
        return view('pages.varietas.edit', compact('varietas'));
    }

    public function update(UpdateVarietasRequest $request, $id)
    {
        $varietas = VarietasAnggur::findOrFail($id);

        $validatedData = $request->validate([
            'nama' => 'required|string',
            'deskripsi' => 'required|text',
            'karakteristik' => 'required|text',
            'gambar' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            if ($varietas->gambar) {
                Storage::disk('public')->delete($varietas->gambar);
            }

            $imagePath = $request->file('gambar')->store('gambar_varietas', 'public');
            $validatedData['gambar'] = $imagePath;
        }

        $varietas->update($validatedData);

        return redirect()->route('varietas.index')->with('success', 'Varietas successfully updated');
    }

    public function destroy($id)
    {
        $varietas = \App\Models\VarietasAnggur::findOrFail($id);
        $varietas->delete();

        return redirect()->route('varietas.index')->with('success', 'Varietas successfully deleted');
    }
}
