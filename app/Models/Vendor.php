<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','service_name','subtitle','category','service','description','image_path',
        'pin_code','area','city','state','street','landmark','latitude','longitude',
        'base_price','discount_percent','rating','contact_number','whatsapp_number','email'
    ];

    public function user(){ return $this->belongsTo(User::class); }
    public function services(){ return $this->hasMany(VendorService::class); }
    public function bookings(){ return $this->hasMany(Booking::class); }
    public function transactions(){ return $this->hasMany(VendorTransaction::class); }

    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image_path) return null;
        if (str_starts_with($this->image_path, 'http')) return $this->image_path;
        return asset('storage/'.$this->image_path);
    }
}
