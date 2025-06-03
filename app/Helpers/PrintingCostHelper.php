<?php
namespace App\Helpers;

class PrintingCostHelper
{
    public static function hitungHPP($jumlahLintasan, $cutWidth, $cutHeight, $kecepatanMesin, $jumlahWarna, $lamaOperasiJam, $konsumsiListrikWatt, $tarifPLN, $penggunaanTinta, $hargaTintaPerKg, $gajiPerJam, $jumlahOperator, $operational, $tintaKhusus = [])
    {
        // Luas Cetak (mm2)
        $luasCetak = $jumlahLintasan * $cutWidth * $cutHeight;

        // Biaya Tinta Proses
        $biayaTintaProses = [];
        foreach ($penggunaanTinta as $tinta) {
            $biayaTintaProses[] = $tinta['kebutuhan_kg'] * $hargaTintaPerKg;
        }

        // Biaya Tinta Khusus
        $biayaTintaKhusus = [];
        foreach ($tintaKhusus as $tinta) {
            $biayaTintaKhusus[$tinta['nama']] = $tinta['biaya'];
        }

        // Biaya Listrik
        $kwh = ($konsumsiListrikWatt * $lamaOperasiJam) / 1000;
        $biayaListrik = $kwh * $tarifPLN;

        // Biaya Gaji Karyawan
        $biayaGaji = ($gajiPerJam * $lamaOperasiJam) * $jumlahOperator;

        // Subtotal
        $subtotal = array_sum($biayaTintaProses) + array_sum($biayaTintaKhusus) + $biayaListrik + $biayaGaji;

        // Operational 10%
        $operational = $subtotal * ($operational / 100);

        // HPP Total
        $hpp = $subtotal + $operational;

        return [
            'luas_cetak'         => $luasCetak,
            'biaya_tinta_proses' => $biayaTintaProses,
            'biaya_tinta_khusus' => $biayaTintaKhusus,
            'biaya_listrik'      => $biayaListrik,
            'biaya_gaji'         => $biayaGaji,
            'subtotal'           => $subtotal,
            'operational'        => $operational,
            'hpp'                => $hpp,
        ];
    }
}