<?php

namespace App\Helpers;

use App\Models\Finishing;

class FinishingCostHelper
{
    public static function hitungFinishing(
        $finishingIds, 
        $lembarDibutuhkan, 
        $cutWidth, 
        $cutHeight,
        $tarifPLN
        )
    {
        $results = [];

        foreach ($finishingIds as $id) {
            $finishing = Finishing::with('mesinFinishing')->find($id);
            if (!$finishing) {
                continue;
            }
                    
            $cutwidthCm = $cutWidth / 10; // Convert mm to cm
            $cutheightCm = $cutHeight / 10; // Convert mm to cm
            $biaya = $cutwidthCm * $cutheightCm * $lembarDibutuhkan * $finishing->hpp_trial;
            $kecepatan = $finishing->mesinFinishing->kecepatan ?: 1000;
            $lamaOperasiJam = ($lembarDibutuhkan / $kecepatan) + ((50 / 100) * $lembarDibutuhkan / $kecepatan);
            $biayaListrikFinishing = ($finishing->mesinFinishing->daya_listrik * $lamaOperasiJam) / 1000 * $tarifPLN; // kWh to Rp
            $biayaKaryawanFinishing = $finishing->mesinFinishing->upah_operator_per_jam * $lamaOperasiJam * $finishing->mesinFinishing->jumlah_operator;

            $results[] = [
                'id' => $finishing->id,
                'jenis_finishing' => $finishing->jenis_finishing,
                'lama_operasi' => $lamaOperasiJam,
                'biaya' => round($biaya),
                'biaya_listrik_finishing' => $biayaListrikFinishing,
                'biaya_karyawan_finishing' => $biayaKaryawanFinishing,
                'total_biaya' => round($biaya) + $biayaListrikFinishing + $biayaKaryawanFinishing,
            ];
        }

        return $results;
    }
}
