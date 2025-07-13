<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MesinFinishing extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'nama', 'kecepatan',
        'daya_listrik',
        'upah_operator_per_jam',
        'jumlah_operator'
    ];

    public function finishings()
    {
        return $this->hasMany(Finishing::class);
    }
}
