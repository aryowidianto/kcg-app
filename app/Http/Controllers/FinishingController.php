<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FinishingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $mesinFinishings = MesinFinishing::all();
        return view('finishings.create', compact('mesinFinishings'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
        'nama' => 'required|string|max:255',
        'hpp_trial' => 'required|numeric',
        'mesin_finishing_id' => 'required|exists:mesin_finishings,id'
    ]);

        Finishing::create($validated);

        return redirect()->route('finishings.index')
            ->with('success', 'Finishing berhasil ditambahkan');
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
