<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MesinOffset extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'nama', 'kecepatan',
        'min_panjang', 'min_lebar',
        'max_panjang', 'max_lebar',
        'harga_ctcp', 'harga_plate',
        'daya_listrik',
        'upah_operator_per_jam',
        'jumlah_operator'
    ];
    
}
