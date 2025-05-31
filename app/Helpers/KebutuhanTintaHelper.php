<?php
// app/Helpers/KebutuhanTintaHelper.php

namespace App\Helpers;

class KebutuhanTintaHelper
{
    public static function hitungKebutuhanTinta(
        $luasAreaCetakMeter,
        $gramasi,
        $jenisKertas,
        $tintasProses,
        $tintasKhusus,
        $lembarDibutuhkan,
        $raster
    ) {
        $lembar_per_kg = 0;
        $lembar_per_kg_tinta_khusus = 0;
        $totalGramTinta = 0;
        $biayaTintaProses = 0;
        $biayaTintaKhusus = 0;
        // Hitung kebutuhan tinta proses (CMYK)
        foreach ($tintasProses as $tinta) {
            $bobot = ($jenisKertas == 'coated')
                ? $tinta->bobot_coated
                : $tinta->bobot_uncoated;
            $lembar_per_kg = 1000 / $bobot / $luasAreaCetakMeter;
            $gramTinta = ($luasAreaCetakMeter * $gramasi * $bobot) / 1000000;
            $totalGramTinta += $gramTinta;
            $biayaTintaProses = ((+$lembar_per_kg / ($raster / 100) / $lembarDibutuhkan) * $tintasProses->count()) * +$tinta->harga;
        }


        $hasilTintasKhusus = [];
        // Hitung kebutuhan tinta khusus (Spot Color)
        foreach ($tintasKhusus as $tinta) {
            $bobot = ($jenisKertas == 'coated')
                ? $tinta->bobot_coated
                : $tinta->bobot_uncoated;

            $lembar_per_kg_tinta_khusus = 1000 / $bobot / $luasAreaCetakMeter;
            $gramTinta = ($luasAreaCetakMeter * $gramasi * $bobot) / 1000000;
            $totalGramTinta += $gramTinta;
            $hasilTintasKhusus[] = [
                'nama' => $tinta->nama,
                'harga' => $tinta->harga,
                'lembar_per_kg' => +$lembar_per_kg_tinta_khusus / ($raster / 100),
                'berat_tinta' => $lembarDibutuhkan / (+$lembar_per_kg_tinta_khusus / ($raster / 100)),
                'total_harga' => ($lembarDibutuhkan / (+$lembar_per_kg_tinta_khusus / ($raster / 100))) * +$tinta->harga,
            ];
            $biayaTintaKhusus += ($lembarDibutuhkan / (+$lembar_per_kg_tinta_khusus / ($raster / 100))) * +$tinta->harga;
        }

        // $total=0;
        // foreach ($hasilTintasKhusus as $key => $value) {
        //     $total += +$value['total_harga'];
        // }
        // dd(
        //     $hasilTintasKhusus,
        //     $lembarDibutuhkan
        // );



        return [
            'lembar_per_kg' => $lembar_per_kg,
            'tinta_khusus' => $hasilTintasKhusus,
            'total_gram_tinta' => $totalGramTinta,
            'biaya_tinta_proses' => $biayaTintaProses,
            'biaya_tinta_khusus' => $biayaTintaKhusus,
        ];
    }
}