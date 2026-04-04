<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'user_id', 'title', 'description', 'price', 'type', 'category', 'condition',
        'city', 'location_text', 'phone', 'image_path', 'status'
    ];

    protected $casts = [
        'image_path' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
