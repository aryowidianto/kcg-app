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
        $tintasKhusus
    ) {
        $lembar_per_kg = 0;
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
            $biayaTintaProses += $gramTinta * $tinta->harga / 1000;
        }

        // Hitung kebutuhan tinta khusus (Spot Color)
        foreach ($tintasKhusus as $tinta) {
            $bobot = ($jenisKertas == 'coated') 
                ? $tinta->bobot_coated 
                : $tinta->bobot_uncoated;

            $lembar_per_kg = 1000 / $bobot / $luasAreaCetakMeter;
            $gramTinta = ($luasAreaCetakMeter * $gramasi * $bobot) / 1000000;
            $totalGramTinta += $gramTinta;
            $biayaTintaKhusus += $gramTinta * $tinta->harga / 1000;
        }

        return [
            'lembar_per_kg'       => $lembar_per_kg,
            'total_gram_tinta'    => $totalGramTinta,
            'biaya_tinta_proses'  => $biayaTintaProses,
            'biaya_tinta_khusus'  => $biayaTintaKhusus,
        ];
    }
}