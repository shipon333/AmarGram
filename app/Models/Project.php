<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }
    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}
