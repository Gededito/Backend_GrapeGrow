<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePenyakitRequest;
use App\Http\Requests\UpdatePenyakitRequest;
use App\Models\PenyakitAnggur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PenyakitAnggurController extends Controller
{
    public function index(Request $request)
    {
        $penyakitAnggur = PenyakitAnggur::query()
        ->when($request->input('nama'), function ($query, $nama) {
            return $query->where('nama', 'like', '%' . $nama . '%');
        })
        ->orderBy('id', 'desc')
        ->paginate(100);

        return view('pages.penyakit.index', compact('penyakitAnggur'));
    }

    public function create()
    {
        return view('pages.penyakit.create');
    }

    public function store(StorePenyakitRequest $request)
    {
        $gambarPenyakit = $request->hasFile('gambar')
            ? $request->file('gambar')->store('gambar_penyakit', 'public')
            : null;

        PenyakitAnggur::create([
            ...$request->all(),
            'gambar' => $gambarPenyakit,
        ]);

        return redirect()->route('penyakit.index')->with('success', 'Penyakit successfully created');
    }

    public function edit($id)
    {
        $penyakitAnggur = PenyakitAnggur::findOrFail($id);
        return view('pages.penyakit.edit', compact('penyakitAnggur'));
    }

    public function update(UpdatePenyakitRequest $request, $id)
    {
        $penyakit = PenyakitAnggur::findOrFail($id);
        $validatedData = $request->validated();

        if ($request->hasFile('gambar')) {
            if ($penyakit->gambar) {
                Storage::disk('public')->delete($penyakit->gambar);
            }
            $validatedData['gambar'] = $request->file('gambar')->store('gambar_penyakit', 'public');
        }

        $validatedData['nama'] = $request->nama;
        $request->validate([
            'nama' => 'unique:penyakit_anggurs,nama,' . $penyakit->id,
        ]);

        $penyakit->update($validatedData);
        return redirect()->route('penyakit.index')->with('success', 'Penyakit successfully updated');
    }

    public function destroy($id)
    {
        $penyakitAnggur = PenyakitAnggur::findOrFail($id);
        $penyakitAnggur->delete();

        return redirect()->route('penyakit.index')->with('success', 'Penyakit successfully deleted');
    }
}
