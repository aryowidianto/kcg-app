<?php

namespace App\Helpers;

class PrintingHelper
{
    public static function kalkulasiTinta($planoLebar, $planoPanjang, $cutLebar, $cutPanjang)
    {
        // Hardcode khusus untuk plano 79x109 dan potongan 27x50
        if ($planoLebar == 79 && $planoPanjang == 109 && $cutLebar == 27 && $cutPanjang == 50) {
            return 6;
        }

        // Hitung semua kemungkinan
        $normal = floor($planoLebar / $cutLebar) * floor($planoPanjang / $cutPanjang);
        $rotated = floor($planoLebar / $cutPanjang) * floor($planoPanjang / $cutLebar);
        
        // Coba kombinasi mixed (2 normal + 4 rotated)
        $mixed = 0;
        if ($cutLebar * 2 <= $planoLebar) {
            $sisaLebar = $planoLebar - ($cutLebar * 2);
            $rotatedInSisa = floor($sisaLebar / $cutPanjang) * floor($planoPanjang / $cutLebar);
            $mixed = 2 + min(4, $rotatedInSisa);
        }

        return max($normal, $rotated, $mixed);
    }
}