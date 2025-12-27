<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Expense extends Model
{
    protected $table = 'expenses';

    protected $fillable = ['group_id','payer_id','payer_name','amount','currency','split_method','splits','category','note','spent_at'];

    protected $casts = [
        'splits' => 'array',
        'spent_at' => 'datetime',
    ];

    public function group(): BelongsTo
    {
        return $this->belongsTo(ExpenseGroup::class, 'group_id');
    }

    public function shares(): HasMany
    {
        return $this->hasMany(ExpenseShare::class, 'expense_id');
    }
}
