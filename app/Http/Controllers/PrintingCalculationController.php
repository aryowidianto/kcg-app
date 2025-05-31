<?php

namespace App\Http\Controllers;

use App\Models\KertasPlano;
use App\Models\Tinta;
use App\Models\MesinOffset;
use Illuminate\Http\Request;
use App\Helpers\PlanoHelper;
use App\Helpers\KebutuhanTintaHelper;

class PrintingCalculationController extends Controller
{
    public function index()
    {
        $kertasPlanos = KertasPlano::orderBy('nama')->get();
        $mesinOffsets = MesinOffset::orderBy('nama')->get();
        $tintasProses = Tinta::where('jenis', 'warna proses')->orderBy('nama')->get();
        $tintasKhusus = Tinta::where('jenis', 'warna khusus')->orderBy('nama')->get();

        return view('printing.calculation', compact(
            'kertasPlanos', 'mesinOffsets', 'tintasProses', 'tintasKhusus'
        ));
    }

    public function calculate(Request $request)
    {
        $validated = $request->validate([
            'oplag'          => 'required|integer|min:1',
            'insheet'        => 'required|numeric|min:0|max:100',
            'jenis_kertas'   => 'required|exists:kertas_planos,id',
            'cut_width'      => 'required|numeric|min:1',
            'cut_height'     => 'required|numeric|min:1',
            'panjang_jadi'   => 'required|numeric|min:1',
            'lebar_jadi'    => 'required|numeric|min:1',
            'mesin_offset'  => 'required|string',
            'raster'         => 'required|numeric|min:1',
            'warna_proses'   => 'nullable|array',
            'warna_proses.*' => 'exists:tintas,id',
            'warna_khusus'   => 'nullable|array',
            'warna_khusus.*' => 'exists:tintas,id',
        ]);

        // Ambil data kertas
        $kertas = KertasPlano::findOrFail($validated['jenis_kertas']);

        // Hitung efisiensi plano
        $jumlahPotongan = PlanoHelper::hitungMaksimalPotongan(
            $kertas->panjang,  // Lebar plano (mm)
            $kertas->lebar,    // Panjang plano (mm)
            $validated['cut_width'],
            $validated['cut_height']
        );

        // Kalkulasi kebutuhan kertas
        $insheetDecimal   = $validated['insheet'] / 100;
        $lembarDibutuhkan = ceil($validated['oplag'] + ($validated['oplag'] * $insheetDecimal));
        $planoDibutuhkan  = ceil($lembarDibutuhkan / max($jumlahPotongan, 1));
        $totalHargaKertas = $planoDibutuhkan * $kertas->harga_per_lembar;
        $luasAreaCetak   = $lembarDibutuhkan * (($validated['cut_width'] / 1000) * ($validated['cut_height'] / 1000));
        $luasAreaCetakMeter = $luasAreaCetak / 10000; // Convert cm² to m²
        // Kalkulasi kebutuhan tinta
        $tintaResult = KebutuhanTintaHelper::hitungKebutuhanTinta(
            $luasAreaCetakMeter,
            $kertas->gramasi,
            $kertas->jenis_kertas,
            Tinta::whereIn('id', $request->input('warna_proses', []))->get(),
            Tinta::whereIn('id', $request->input('warna_khusus', []))->get()
        );

        // Biaya per potong (opsional)
        $biayaPerPotong = $kertas->harga_per_lembar / max($jumlahPotongan, 1);

        return redirect()->route('printing.calculation')->with([
            'calculation_result' => [
                // Data kertas
                'kertas'              => $kertas,
                'input'               => $validated,

                // Hasil kalkulasi kertas
                'lembar_dibutuhkan'   => $lembarDibutuhkan,
                'jumlah_potongan'     => max($jumlahPotongan, 1),
                'plano_dibutuhkan'    => $planoDibutuhkan,
                'total_harga_kertas'  => $totalHargaKertas,
                'biaya_per_potong'    => $biayaPerPotong,

                // Hasil kalkulasi tinta
                'raster'             => $validated['raster'],
                'lembar_per_kg'       => $tintaResult['lembar_per_kg'] / ($validated['raster'] / 100),
                'total_gram_tinta'    => $tintaResult['total_gram_tinta'],
                'biaya_tinta_proses'  => $tintaResult['biaya_tinta_proses'],
                'biaya_tinta_khusus'  => $tintaResult['biaya_tinta_khusus'],
                'total_biaya_tinta'   => $tintaResult['biaya_tinta_proses'] + $tintaResult['biaya_tinta_khusus'],

                // Data tambahan
                'luas_area_cetak'     => $luasAreaCetakMeter,
            ]
        ]);
    }
}