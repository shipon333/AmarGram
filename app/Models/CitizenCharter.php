<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CitizenCharter extends Model
{
    use HasFactory;
    public function union(){
        return $this->belongsTo(Union::class,'union_id','id');
    }
}
