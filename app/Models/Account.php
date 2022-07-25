<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Account extends Model
{
    use HasFactory;
    protected $appends=['balance'];

    public function transactions(){
        return $this->hasMany(Transaction::class);
    }
    public function balance(){
        return $this->transactions()->sum(DB::raw('debit-credit'));
    }

    public function getBalanceAttribute()
    {
        return number_format($this->balance(),2);
    }
    public function organization(){
        return $this->belongsTo(Organization::class);
    }
}
