<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpenseShare extends Model
{
    protected $table = 'expense_shares';

    protected $fillable = ['expense_id','member','member_id','amount'];

    public function expense()
    {
        return $this->belongsTo(Expense::class, 'expense_id');
    }
}
