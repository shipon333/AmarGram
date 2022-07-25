<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    protected $appends = ['people','project'];

    public function people()
    {
        return $this->belongsTo(People::class);
    }
//    public function received_by()
//    {
//        return $this->belongsTo(People::class,'received_by','id');
//    }
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    public function getPeopleAttribute()
    {
        return $this->people()->first();
    }
    public function getProjectAttribute()
    {
        return $this->project()->first();
    }
    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}
