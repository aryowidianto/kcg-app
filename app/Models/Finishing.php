<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\MesinFinishing;

class Finishing extends Model
{
    protected $fillable = [
        'jenis_finishing',
        'hpp_trial',
        'mesin_finishing_id'
    ];

    public function mesinFinishing()
    {
        return $this->belongsTo(MesinFinishing::class);
    }
}
