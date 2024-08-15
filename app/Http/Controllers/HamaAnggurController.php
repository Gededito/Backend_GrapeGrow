<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreHamaRequest;
use App\Http\Requests\UpdateHamaRequest;
use App\Models\HamaAnggur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class HamaAnggurController extends Controller
{
    //
    public function index(Request $request)
    {
        // $hama = \App\Models\HamaAnggur::paginate(10);

        $hama = DB::table('hama_anggurs')
        ->when($request->input('nama'), function ($query, $nama) {
            return $query->where('nama', 'like', '%'.$nama.'%');
        })
        ->orderBy('id', 'desc')
        ->paginate(100);
        return view('pages.hama.index', compact('hama'));
    }

    public function create()
    {
        return view('pages.hama.create');
    }

    public function store(StoreHamaRequest $request)
    {
        $gambarHama = null;
        if ($request->hasFile('gambar')) {
            $gambarHama = $request->file('gambar')->store('gambar_opt', 'public');
        }

        $data = $request->all();
        $data['gambar'] = $gambarHama;

        HamaAnggur::create($data);
        return redirect()->route('hama.index')->with('success', 'Hama successfully created');
    }

    public function edit($id)
    {
        $hama = \App\Models\HamaAnggur::findOrFail($id);
        return view('pages.hama.edit', compact('hama'));
    }

    public function update(UpdateHamaRequest $request, $id)
    {
        $hama = HamaAnggur::findOrFail($id);

        $validatedData = $request->validate([
            'nama' => 'required|unique:hama_anggurs,nama',
            'gejala' => 'required|string',
            'solusi' => 'required|string',
            'penyebab' => 'string|string',
            'gambar' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            if ($hama->gambar) {
                Storage::disk('public')->delete($hama->gambar);
            }

            $imagePath = $request->file('gambar')->store('gambar_opt', 'public');
            $validatedData['gambar'] = $imagePath;
        }

        $hama->update($validatedData);

        return redirect()->route('hama.index')->with('success', 'Hama successfully updated');
    }

    public function destroy($id)
    {
        $hama = \App\Models\HamaAnggur::findOrFail($id);
        $hama->delete();

        return redirect()->route('hama.index')->with('success', 'Hama successfully deleted');
    }
}
