<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $appends = ['expense_type'];

    public function expense_type()
    {
        return $this->belongsTo(ExpenseType::class);
    }
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    public function getExpenseTypeAttribute()
    {
        return $this->expense_type()->first();
    }
}
