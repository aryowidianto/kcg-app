<?php

namespace App\Http\Controllers;

use App\Models\Finishing;
use App\Models\MesinFinishing;
use Illuminate\Http\Request;

class FinishingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $finishings = Finishing::with('mesinFinishing')->get();
        return view('finishings.index', compact('finishings'));
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
        $request->validate([
            'jenis_finishing' => 'required|string|max:255',
            'hpp_trial' => 'required|numeric',
            'mesin_finishing_id' => 'required|exists:mesin_finishings,id'
        ]);

        Finishing::create($request->all());

        return redirect()->route('finishings.index')
            ->with('success', 'Data finishing berhasil ditambahkan');
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
    $finishing = \App\Models\Finishing::findOrFail($id);
    $mesinFinishings = \App\Models\MesinFinishing::all();
    return view('finishings.edit', compact('finishing', 'mesinFinishings'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'jenis_finishing' => 'required|string|max:255',
            'hpp_trial' => 'required|numeric',
            'mesin_finishing_id' => 'required|exists:mesin_finishings,id'
        ]);

        $finishing = \App\Models\Finishing::findOrFail($id);
        $finishing->update($request->all());

        return redirect()->route('finishings.index')->with('success', 'Data finishing berhasil diupdate!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $finishings = \App\Models\Finishing::findOrFail($id);
        $finishings->delete();

        return redirect()->route('finishings.index')->with('success', 'Data finishing berhasil dihapus!');
    }
}
