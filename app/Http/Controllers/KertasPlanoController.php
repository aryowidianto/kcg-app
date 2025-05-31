<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
class KertasPlanoController extends Controller
{
    
    public function index()
    {
    $kertas_plano = \App\Models\KertasPlano::all();
    return view('kertas-plano.index', compact('kertas_plano'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    return view('kertas-plano.create');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    $request->validate([
        'nama' => 'required',
        'panjang' => 'required|integer',
        'lebar' => 'required|integer',
        'gramasi' => 'required|integer',
        'jenis_kertas' => 'required|in:coated,uncoated',
        'harga_per_lembar' => 'required|numeric',
    ]);

    \App\Models\KertasPlano::create($request->all());

    return redirect()->route('kertas-plano.index')->with('success', 'Kertas Plano berhasil ditambahkan.');
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

    public function edit($id)
    {
    $kertas_plano = \App\Models\KertasPlano::findOrFail($id);
    return view('kertas-plano.edit', compact('kertas_plano'));
    }


    /**
     * Update the specified resource in storage.
     */
    
    public function update(Request $request, $id)
    {
        $request->validate([
        'nama' => 'required',
        'panjang' => 'required|integer',
        'lebar' => 'required|integer',
        'gramasi' => 'required|integer',
        'jenis_kertas' => 'required|in:coated,uncoated',
        'harga_per_lembar' => 'required|numeric',
        ]);

        $kertas_plano = \App\Models\KertasPlano::findOrFail($id);
        $kertas_plano->update($request->all());

        return redirect()->route('kertas-plano.index')->with('success', 'Data kertas plano berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
    $kertas_plano = \App\Models\KertasPlano::findOrFail($id);
    $kertas_plano->delete();

    return redirect()->route('kertas-plano.index')->with('success', 'Data berhasil dihapus.');
    }
}
