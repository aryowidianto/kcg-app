<?php

namespace App\Helpers;

class PlanoHelper
{
    public static function hitungMaksimalPotongan($planoWidth, $planoHeight, $cutWidth, $cutHeight)
    {
        if ($cutWidth <= 0 || $cutHeight <= 0) return 0;

        $orientasi = [
            [$cutWidth, $cutHeight],
            [$cutHeight, $cutWidth],
        ];

        $max = 0;

        foreach ($orientasi as [$cw, $ch]) {
            for ($x = 0; $x <= floor($planoWidth / $cw); $x++) {
                for ($y = 0; $y <= floor($planoHeight / $ch); $y++) {
                    $usedWidth  = $x * $cw;
                    $usedHeight = $y * $ch;

                    if ($usedWidth > $planoWidth || $usedHeight > $planoHeight) continue;

                    $count = $x * $y;

                    $remainingWidth  = $planoWidth - $usedWidth;
                    $remainingHeight = $planoHeight - $usedHeight;

                    foreach ($orientasi as [$cw2, $ch2]) {
                        $extraRight  = floor($remainingWidth / $cw2) * floor($planoHeight / $ch2);
                        $extraBottom = floor($planoWidth / $cw2) * floor($remainingHeight / $ch2);
                        $extraCorner = floor($remainingWidth / $cw2) * floor($remainingHeight / $ch2);
                        $total = $count + $extraRight + $extraBottom - $extraCorner;
                        $max = max($max, $total);
                    }

                    $max = max($max, $count);
                }
            }
        }

        return $max;
    }
}