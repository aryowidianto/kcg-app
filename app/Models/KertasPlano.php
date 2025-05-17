<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KertasPlano extends Model
{
    use HasFactory;
    protected $table = 'kertas_planos'; // Nama tabel di database
    protected $fillable = ['nama', 'panjang', 'lebar', 'gramasi', 'harga_per_lembar'];

}
