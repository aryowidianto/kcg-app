<?php
// app/Helpers/KebutuhanTintaHelper.php

namespace App\Helpers;

class KebutuhanTintaHelper
{
    public static function hitungKebutuhanTinta(
        $luasAreaCetakMeter,
        $areaCetakPerLembar,
        $gramasi,
        $jenisKertas,
        $tintasProses,
        $tintasKhusus,
        $lembarDibutuhkan,
        $raster
    ) {
        $lembar_per_kg = 0;
        $lembar_per_kg_tinta_khusus = 0;
        $biayaTintaProses = 0;
        $biayaTintaKhusus = 0;
        // Hitung kebutuhan tinta proses (CMYK)
        foreach ($tintasProses as $tinta) {
            $bobot = ($jenisKertas == 'coated')
                ? $tinta->bobot_coated
                : $tinta->bobot_uncoated;
            $lembar_per_kg = 1000 / $bobot / ($areaCetakPerLembar / 1000000) / ($raster / 100); // Convert mm² to m²
        }
        $biayaTintaProses = (($lembarDibutuhkan / $lembar_per_kg) * $tintasProses->count() * $tinta->harga);


        $hasilTintasKhusus = [];
        // Hitung kebutuhan tinta khusus (Spot Color)
        foreach ($tintasKhusus as $tinta) {
            $bobot = ($jenisKertas == 'coated')
                ? $tinta->bobot_coated
                : $tinta->bobot_uncoated;

            $lembar_per_kg_tinta_khusus = 1000 / $bobot / ($areaCetakPerLembar / 1000000)  / ($raster / 100); // Convert mm² to m²
            $biayaTintaKhusus += (($lembarDibutuhkan / $lembar_per_kg_tinta_khusus) * $tinta->harga);
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
            'lembar_per_kg_tinta_khusus' => $lembar_per_kg_tinta_khusus,
            'tinta_khusus' => $hasilTintasKhusus,
            'biaya_tinta_proses' => $biayaTintaProses,
            'biaya_tinta_khusus' => $biayaTintaKhusus,
        ];
    }
}