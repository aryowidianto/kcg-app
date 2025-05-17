<?php

// app/Http/Controllers/PrintingCalculationController.php
namespace App\Http\Controllers;

use App\Models\KertasPlano;
use App\Models\Tinta;
use App\Models\MesinOffset;
use Illuminate\Http\Request;
use App\Helpers\PlanoHelper;
use App\Helpers\TintaHelper;

class PrintingCalculationController extends Controller
{
    public function index()
    {
        $kertasPlanos = KertasPlano::orderBy('nama')->get();
        $mesinOffsets = MesinOffset::orderBy('nama')->get();
        $tintas = Tinta::orderBy('nama')->get();
        $tintasProses = Tinta::where('jenis', 'warna proses')->orderBy('nama')->get();
        $tintasKhusus = Tinta::where('jenis', 'warna khusus')->orderBy('nama')->get();

        return view('printing.calculation', compact('kertasPlanos', 'mesinOffsets', 'tintasProses', 'tintasKhusus'));
    }

    public function calculate(Request $request)
    {
        $validated = $request->validate([
            'oplag'         => 'required|integer|min:1',
            'insheet'       => 'required|numeric|min:0|max:100',
            'jenis_kertas'  => 'required|exists:kertas_planos,id',
            'cut_width'     => 'required|numeric|min:1',
            'cut_height'    => 'required|numeric|min:1',
            'panjang_jadi'  => 'required|numeric|min:1',
            'lebar_jadi'    => 'required|numeric|min:1',
            'mesin_offset'  => 'required|string',
            'warna_khusus.*' => 'exists:tintas,id',
            'warna_proses.*' => 'exists:tintas,id',
        ]);

        $kertas = KertasPlano::find($validated['jenis_kertas']);

        // Ambil data dari request
        $planoWidth  = $kertas->panjang; // Contoh: 1090
        $planoHeight = $kertas->lebar;   // Contoh: 790
        $cutWidth    = $request->input('cut_width');   // Contoh: 460
        $cutHeight   = $request->input('cut_height');  // Contoh: 330

        // Hitung jumlah potongan maksimal
        $jumlahPotongan = PlanoHelper::hitungMaksimalPotongan($planoWidth, $planoHeight, $cutWidth, $cutHeight);

        // Kalkulasi detail
        $insheetDecimal   = $validated['insheet'] / 100;
        $lembarDibutuhkan = ceil($validated['oplag'] + ($validated['oplag'] * $insheetDecimal));
        $planoDibutuhkan  = $lembarDibutuhkan / $jumlahPotongan;
        $totalHargaKertas = $planoDibutuhkan * $kertas->harga_per_lembar;
        $luasAreaCetak    = $lembarDibutuhkan * $validated['cut_width'] * $validated['cut_height'];

        // Hitung biaya per lembar berdasarkan efisiensi
        $biayaPerPotong = $kertas->harga_per_lembar / max($jumlahPotongan, 1);

        return redirect()->route('printing.calculation')->with([
            'calculation_result' => [
                'lembar_dibutuhkan'   => $lembarDibutuhkan,
                'jumlah_potongan'     => max($jumlahPotongan, 1),
                'plano_dibutuhkan'    => $planoDibutuhkan,
                'luas_area_cetak'     => $luasAreaCetak,
                'total_harga_kertas'  => $totalHargaKertas,
                'kertas'              => $kertas,
                'input'               => $validated,
                'biaya_per_potong'    => $biayaPerPotong
            ]
        ]);
    }

}