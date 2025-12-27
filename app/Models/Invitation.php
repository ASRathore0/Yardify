<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    protected $table = 'invitations';

    protected $fillable = ['group_id','email','token','invited_by','accepted_at'];

    protected $casts = [
        'accepted_at' => 'datetime',
    ];

    public function group()
    {
        return $this->belongsTo(ExpenseGroup::class, 'group_id');
    }
}
