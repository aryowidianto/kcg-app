<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MesinOffsetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    $mesin = \App\Models\MesinOffset::all();
    return view('mesin-offset.index', compact('mesin'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('mesin-offset.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    $request->validate([
        'nama' => 'required',
        'kecepatan' => 'required|integer',
        'min_panjang' => 'required|integer',
        'min_lebar' => 'required|integer',
        'max_panjang' => 'required|integer',
        'max_lebar' => 'required|integer',
        'harga_ctcp' => 'required|numeric',
        'harga_plate' => 'required|numeric',
        'daya_listrik' => 'required|numeric',
        'upah_operator_per_jam' => 'required|numeric',
    ]);

    \App\Models\MesinOffset::create($request->all());

    return redirect()->route('mesin-offset.index')->with('success', 'Mesin berhasil ditambahkan.');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
