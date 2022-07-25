<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    public function memberType(){
        return $this->belongsTo(MemberType::class,'member_type_id','id');
    }
    public function people(){
        return $this->belongsTo(People::class,'people_id','id');
    }
}
