<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommitteeDetails extends Model
{
    use HasFactory;
    public function committee(){
        return $this->belongsTo(Committee::class,'committee_id','id');
    }
    public function member(){
        return $this->belongsTo(Member::class,'member_id','id');
    }
    public function committeeDesignation(){
        return $this->belongsTo(CommitteeDesignation::class,'committee_designation_id','id');
    }
}
