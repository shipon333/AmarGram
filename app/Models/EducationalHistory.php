<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EducationalHistory extends Model
{
    use HasFactory;
    public function educationType(){
        return $this->belongsTo(EducationType::class,'education_type_id','id');
    }
}
