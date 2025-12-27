<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Settlement extends Model
{
    protected $fillable = ['group_id','created_by','snapshot','total_amount'];

    protected $casts = [
        'snapshot' => 'array',
        'total_amount' => 'float',
    ];

    public function group()
    {
        return $this->belongsTo(ExpenseGroup::class, 'group_id');
    }
}
