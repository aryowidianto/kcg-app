<?php

namespace App\Http\Controllers;

use App\Models\Config;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    public function index()
    {
        $configs = Config::all();
        return view('config.index', compact('configs'));
    }

    public function create()
    {
        return view('config.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tarif_pln' => 'required|numeric',
            'gaji_per_jam' => 'required|numeric',
        ]);
        Config::create($validated);
        return redirect()->route('config.index')->with('success', 'Config berhasil ditambahkan!');
    }

    public function edit(Config $config)
    {
        return view('config.edit', compact('config'));
    }

    public function update(Request $request, Config $config)
    {
        $validated = $request->validate([
            'tarif_pln' => 'required|numeric',
            'gaji_per_jam' => 'required|numeric',
        ]);
        $config->update($validated);
        return redirect()->route('config.index')->with('success', 'Config berhasil diupdate!');
    }

    public function destroy(Config $config)
    {
        $config->delete();
        return redirect()->route('config.index')->with('success', 'Config berhasil dihapus!');
    }
}