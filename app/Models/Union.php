<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Union extends Model
{
    use HasFactory;
    public function upozilla(){
        return $this->belongsTo(Upozilla::class,'upozilla_id','id');
    }
}
