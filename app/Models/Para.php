<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Para extends Model
{
    use HasFactory;

    public function village(){
        return $this->belongsTo(Village::class,'village_id','id');
    }
}
