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
    public function index(Request $request)
    {
        $varietas = VarietasAnggur::query()
        ->when($request->input('nama'), function ($query, $nama) {
            return $query->where('nama', 'like', '%' . $nama . '%');
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
        $gambarVarietas = $request->hasFile('gambar')
            ? $request->file('gambar')->store('gambar_varietas', 'public')
            : null;

        VarietasAnggur::create([
            ...$request->all(),
            'gambar' => $gambarVarietas,
        ]);

        return redirect()->route('varietas.index')->with('success', 'Varietas successfully created');
    }

    public function edit($id)
    {
        $varietas = VarietasAnggur::findOrFail($id);
        return view('pages.varietas.edit', compact('varietas'));
    }

    public function update(UpdateVarietasRequest $request, $id)
    {
        $varietas = VarietasAnggur::findOrFail($id);
        $validatedData = $request->validated();

        if ($request->hasFile('gambar')) {
            if ($varietas->gambar) {
                Storage::disk('public')->delete($varietas->gambar);
            }
            $validatedData['gambar'] = $request->file('gambar')->store('gambar_varietas', 'public');
        }

        $validatedData['nama'] = $request->nama;
        $request->validate([
            'nama' => 'unique:varietas_anggurs,nama,' . $varietas->id,
        ]);

        $varietas->update($validatedData);
        return redirect()->route('varietas.index')->with('success', 'Varietas successfully updated');
    }

    public function destroy($id)
    {
        $varietas = VarietasAnggur::findOrFail($id);
        $varietas->delete();

        return redirect()->route('varietas.index')->with('success', 'Varietas successfully deleted');
    }
}
