<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExpenseGroup extends Model
{
    use SoftDeletes;
    protected $table = 'expense_groups';

    protected $fillable = ['name', 'description', 'currency', 'members', 'created_by'];

    protected $casts = [
        'members' => 'array',
    ];

    public function expenses()
    {
        return $this->hasMany(Expense::class, 'group_id');
    }

    public function invitations()
    {
        return $this->hasMany(\App\Models\Invitation::class, 'group_id');
    }
}
