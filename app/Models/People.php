<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class People extends Model
{
    use HasFactory;
    protected $table='peoples';
    protected $appends=['point'];

    public function father()
    {
        return $this->belongsTo(People::class, 'father_id','id');
    }
    public function mother()
    {
        return $this->belongsTo(People::class, 'mother_id','id');
    }

    public function para(){
        return $this->belongsTo(Para::class,'para_id','id');
    }
    public function village(){
        return $this->belongsTo(Village::class,'village_id','id');
    }
    public function spouse(){
        return $this->belongsTo(People::class,'spouse_id ','id');
    }

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }
    public function point(){
        return $this->hasMany(PointDetails::class,'people_id','id');
    }
    public function getPointAttribute(){
       return $this->point()->sum('point');
    }

}
