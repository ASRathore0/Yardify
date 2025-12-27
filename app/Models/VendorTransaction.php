<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id','booking_id','type','amount','description','status'
    ];

    public function vendor(){ return $this->belongsTo(Vendor::class); }
    public function booking(){ return $this->belongsTo(Booking::class); }
}
