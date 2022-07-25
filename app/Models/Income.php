<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    use HasFactory;

    protected $appends = ['income_type'];

    public function income_type()
    {
        return $this->belongsTo(IncomeType::class);
    }
    public function investment()
    {
        return $this->belongsTo(Investment::class);
    }
    public function getIncomeTypeAttribute()
    {
        return $this->income_type()->first();
    }
}
