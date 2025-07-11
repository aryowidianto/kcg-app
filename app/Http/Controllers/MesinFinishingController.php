<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MesinFinishingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    $mesinFinishing = \App\Models\MesinFinishing::all();
    return view('mesin-finishing.index', compact('mesinFinishing'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('mesin-finishing.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    $request->validate([
        'nama' => 'required',
        'kecepatan' => 'required|integer',
        'daya_listrik' => 'required|numeric',
        'upah_operator_per_jam' => 'required|numeric',
        'jumlah_operator' => 'required|integer',
    ]);

    \App\Models\MesinFinishing::create($request->all());

    return redirect()->route('mesin-finishing.index')->with('success', 'Mesin Finishing berhasil ditambahkan.');
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
    $mesinFinishing = \App\Models\MesinFinishing::findOrFail($id);
    return view('mesin-finishing.edit', compact('mesinFinishing'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama' => 'required',
            'kecepatan' => 'required|integer',
            'daya_listrik' => 'required|numeric',
            'upah_operator_per_jam' => 'required|numeric',
            'jumlah_operator' => 'required|integer',
        ]);

        $mesin = \App\Models\MesinFinishing::findOrFail($id);
        $mesin->update($request->all());

        return redirect()->route('mesin-finishing.index')->with('success', 'Mesin Finishing berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
