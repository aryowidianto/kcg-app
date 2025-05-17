<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TintaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tinta = \App\Models\Tinta::all();
        return view('tinta.index', compact('tinta'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tinta.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    $request->validate([
        'nama' => 'required',
        'jenis' => 'required',
        'bobot_coated' => 'required|numeric',
        'bobot_uncoated' => 'required|numeric',
        'harga' => 'required|numeric',
    ]);

    \App\Models\Tinta::create($request->all());

    return redirect()->route('tinta.index')->with('success', 'Tinta berhasil ditambahkan.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $tinta = \App\Models\Tinta::findOrFail($id);
        return view('tinta.edit', compact('tinta'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama' => 'required',
            'jenis' => 'required',
            'bobot_coated' => 'required|numeric',
            'bobot_uncoated' => 'required|numeric',
            'harga' => 'required|numeric',
        ]);

        $tinta = \App\Models\Tinta::findOrFail($id);
        $tinta->update($request->all());

        return redirect()->route('tinta.index')->with('success', 'Data tinta berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tinta = \App\Models\Tinta::findOrFail($id);
        $tinta->delete();

        return redirect()->route('tinta.index')->with('success', 'Data tinta berhasil dihapus!');
    }
}
