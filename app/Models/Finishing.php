<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Finishing extends Model
{
    protected $fillable = [
        'nama',
        'hpp_trial',
        'mesin_finishing_id'
    ];

    public function mesin()
    {
        return $this->belongsTo(MesinFinishing::class, 'mesin_finishing_id');
    }
}
