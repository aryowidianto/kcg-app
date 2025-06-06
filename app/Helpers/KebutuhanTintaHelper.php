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
        $biayaTintaProses = 0;
        $biayaTintaKhusus = 0;


        // Hitung kebutuhan tinta proses (CMYK)
        $hasilTintasProses = [];
        foreach ($tintasProses as $tinta) {
            $bobot = ($jenisKertas == 'coated')
                ? $tinta->bobot_coated
                : $tinta->bobot_uncoated;
            $lembar_per_kg_tinta_proses = 1000 / $bobot / ($areaCetakPerLembar / 1000000) / ($raster / 100);
            $hasilTintasProses[] = [
            'nama' => $tinta->nama,
            'lembar_per_kg' => $lembar_per_kg_tinta_proses,
            'kebutuhan_kg' => $lembarDibutuhkan / $lembar_per_kg_tinta_proses,
            'biaya' => ($lembarDibutuhkan / $lembar_per_kg_tinta_proses) * $tinta->harga
        ];
            $biayaTintaProses += (($lembarDibutuhkan / $lembar_per_kg_tinta_proses) * $tinta->harga);
        }

        // Hitung kebutuhan tinta khusus (Spot Color)
        $hasilTintasKhusus = [];

        foreach ($tintasKhusus as $tinta) {
            $bobot = ($jenisKertas == 'coated')
                ? $tinta->bobot_coated
                : $tinta->bobot_uncoated;
            $lembar_per_kg_tinta_khusus = 1000 / $bobot / ($areaCetakPerLembar / 1000000)  / ($raster / 100); // Convert mm² to m²
            $hasilTintasKhusus[] = [
                'nama' => $tinta->nama,
                'lembar_per_kg' => $lembar_per_kg_tinta_khusus,
                'kebutuhan_kg' => $lembarDibutuhkan / $lembar_per_kg_tinta_khusus,
                'biaya' => ($lembarDibutuhkan / $lembar_per_kg_tinta_khusus) * $tinta->harga
        ];
            $biayaTintaKhusus += (($lembarDibutuhkan / $lembar_per_kg_tinta_khusus) * $tinta->harga);
    }
        // Kembalikan hasil sebagai array
        return [
            'lembar_per_kg'         => $lembar_per_kg,
            'tinta_khusus_details'  => $hasilTintasKhusus, // Detail per tinta khusus
            'tinta_proses_details'  => $hasilTintasProses, // Detail per tinta proses
            'biaya_tinta_proses'    => $biayaTintaProses,
            'biaya_tinta_khusus'    => $biayaTintaKhusus,
        ];
    }
}