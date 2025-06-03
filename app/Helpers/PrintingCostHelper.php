<?php
namespace App\Helpers;

class PrintingCostHelper
{
  public static function hitungHPP($jumlahLintasan, $cutWidth, $cutHeight, $jumlahWarna, $lamaOperasiJam, $konsumsiListrikWatt, $tarifPLN, $gajiPerJam, $jumlahOperator, $operational, $biayaAcuanCetak, $totalBiayaTinta, $totalHargaKertas)
  {
    // Luas Cetak (mm2)
    $luasCetak = $jumlahLintasan * $cutWidth * $cutHeight;

    // Biaya acuan cetak
    $biayaAcuan = $biayaAcuanCetak * $jumlahWarna;

    // Biaya Listrik
    $kwh = ($konsumsiListrikWatt * $lamaOperasiJam) / 1000;
    $biayaListrik = $kwh * $tarifPLN;

    // Biaya Gaji Karyawan
    $biayaGaji = ($gajiPerJam * $lamaOperasiJam) * $jumlahOperator;

    // Subtotal
    $subtotal = $biayaListrik + $biayaGaji + $biayaAcuan;

    // Operational 10%
    $operational = $subtotal * ($operational / 100);

    // HPP Total
    $hpp = $subtotal + $operational;

    return [
      'lama_operasi' => $lamaOperasiJam,
      'luas_cetak' => $luasCetak,
      'biaya_listrik' => $biayaListrik,
      'biaya_gaji' => $biayaGaji,
      'biaya_acuan_cetak' => $biayaAcuan,
      'subtotal' => $subtotal,
      'operational' => $operational,
      'hpp' => $hpp + $totalBiayaTinta + $totalHargaKertas, // Total HPP termasuk tinta dan kertas
    ];
  }
}