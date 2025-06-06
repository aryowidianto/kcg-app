<?php

namespace App\Http\Controllers;

use App\Models\KertasPlano;
use App\Models\Tinta;
use App\Models\MesinOffset;
use App\Models\Config;
use Illuminate\Http\Request;
use App\Helpers\PlanoHelper;
use App\Helpers\KebutuhanTintaHelper;
use App\Helpers\PrintingCostHelper;

class PrintingCalculationController extends Controller
{
    public function index()
    {
        $kertasPlanos = KertasPlano::orderBy('nama')->get();
        $mesinOffsets = MesinOffset::orderBy('nama')->get();
        $tintasProses = Tinta::where('jenis', 'warna proses')->orderBy('nama')->get();
        $tintasKhusus = Tinta::where('jenis', 'warna khusus')->orderBy('nama')->get();

        return view('printing.calculation', compact(
            'kertasPlanos',
            'mesinOffsets',
            'tintasProses',
            'tintasKhusus'
        ));
    }

    public function calculate(Request $request)
    {
        // dd($request->all());dd
        $validated = $request->validate([
            'oplag' => 'required|integer|min:1',
            'insheet' => 'required|numeric|min:0|max:100',
            'jenis_kertas' => 'required|exists:kertas_planos,id',
            'cut_width' => 'required|numeric|min:1',
            'cut_height' => 'required|numeric|min:1',
            'panjang_jadi' => 'required|numeric|min:1',
            'lebar_jadi' => 'required|numeric|min:1',
            'mesin_offset' => 'required|exists:mesin_offsets,id',
            'acuan_cetak' => 'required|in:ctcp,plate',
            'raster' => 'required|numeric|min:1',
            'warna_proses' => 'nullable|array',
            'warna_proses.*' => 'exists:tintas,id',
            'warna_khusus' => 'nullable|array',
            'warna_khusus.*' => 'exists:tintas,id',
            'operational' => 'nullable|numeric|min:0',
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
        $insheetDecimal = $validated['insheet'] / 100;
        $lembarDibutuhkan = ceil($validated['oplag'] + ($validated['oplag'] * $insheetDecimal));
        $planoDibutuhkan = ceil($lembarDibutuhkan / max($jumlahPotongan, 1));
        $totalHargaKertas = $planoDibutuhkan * $kertas->harga_per_lembar;
        $areaCetakPerLembar = $validated['cut_width'] * $validated['cut_height']; // mm²
        $luasAreaCetak = $lembarDibutuhkan * ($validated['cut_width'] * $validated['cut_height']);
        $luasAreaCetakMeter = $luasAreaCetak / 1000000; // Convert mm² to m²
        $tintaProses = Tinta::whereIn('id', $request->input('warna_proses', []))->get();
        $tintaKhusus = Tinta::whereIn('id', $request->input('warna_khusus', []))->get();

        // Kalkulasi kebutuhan tinta
        $tintaResult = KebutuhanTintaHelper::hitungKebutuhanTinta(
            $luasAreaCetakMeter,
            $areaCetakPerLembar,
            $kertas->gramasi,
            $kertas->jenis_kertas,
            $tintaProses,
            $tintaKhusus,
            $lembarDibutuhkan,
            $validated['raster']
        );

        $mesinOffset = MesinOffset::findOrFail($request->input('mesin_offset', 1));
        $config = Config::find(1); // Ambil konfigurasi dari database
        
        $hppResult = PrintingCostHelper::hitungHPP(
            $lembarDibutuhkan, // jumlahLintasan
            $validated['cut_width'],   // cutWidth
            $validated['cut_height'],   // cutHeight
            count(isset($validated['warna_proses']) ? $validated['warna_proses'] : []) + count(isset($validated['warna_khusus']) ? $validated['warna_khusus'] : []),     // jumlahWarna
            ($lembarDibutuhkan / $mesinOffset->kecepatan) + ((50 / 100) * $lembarDibutuhkan / $mesinOffset->kecepatan),   // lamaOperasiJam
            $mesinOffset->daya_listrik,  // konsumsiListrikWatt
            $config->tarif_pln,  // tarifPLN
            $mesinOffset->upah_operator_per_jam,  // gajiPerJam
            $mesinOffset->jumlah_operator, // jumlahOperator
            $validated['operational'] ?? 0, // operational,
            ($validated['acuan_cetak'] === 'ctcp') ? $mesinOffset->harga_ctcp : $mesinOffset->harga_plate,
            $tintaResult['biaya_tinta_proses'] + $tintaResult['biaya_tinta_khusus'],
            $totalHargaKertas
        );

        // Biaya per potong (opsional)
        $biayaPerPotong = $kertas->harga_per_lembar / max($jumlahPotongan, 1);

        return redirect()->route('printing.calculation')->with([
            'calculation_result' => [
                // Data kertas
                'kertas' => $kertas,
                'input' => $validated,

                // Hasil kalkulasi kertas
                'lembar_dibutuhkan' => $lembarDibutuhkan,
                'jumlah_potongan' => max($jumlahPotongan, 1),
                'plano_dibutuhkan' => $planoDibutuhkan,
                'total_harga_kertas' => $totalHargaKertas,
                'biaya_per_potong' => $biayaPerPotong,

                // Hasil kalkulasi tinta
                'tinta_proses' => $tintaProses,
                'tinta_khusus' => $tintaKhusus,
                'raster' => $validated['raster'],
                'lembar_per_kg' => $tintaResult['lembar_per_kg'],
                'tinta_khusus_details' => $tintaResult['tinta_khusus_details'], // Detail per tinta khusus
                'tinta_proses_details' => $tintaResult['tinta_proses_details'], // Detail per tinta proses
                'biaya_tinta_proses' => $tintaResult['biaya_tinta_proses'],
                'biaya_tinta_khusus' => $tintaResult['biaya_tinta_khusus'],
                'total_biaya_tinta' => $tintaResult['biaya_tinta_proses'] + $tintaResult['biaya_tinta_khusus'],

                // Data tambahan
                'luas_area_cetak' => $luasAreaCetakMeter,
                'area_cetak_per_lembar' => $areaCetakPerLembar,

                // hpp
                'hpp' => $hppResult,
            ]
        ]);
    }
}