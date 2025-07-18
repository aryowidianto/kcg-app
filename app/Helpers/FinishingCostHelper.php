<?php

namespace App\Helpers;

use App\Models\Finishing;

class FinishingCostHelper
{
    public static function hitungFinishing(array $finishingIds, int $lembarDibutuhkan, float $cutWidth, float $cutHeight): array
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

            $results[] = [
                'id' => $finishing->id,
                'jenis_finishing' => $finishing->jenis_finishing,
                'total_biaya' => round($biaya),
            ];
        }

        return $results;
    }
}
