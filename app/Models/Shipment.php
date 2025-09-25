<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    protected $guarded = ['id'];
    public function getRouteKeyName()
    {
        return 'shipment_number';
    }
    public function histories()
    {
        return $this->hasMany(ShipmentHistory::class, 'shipment_id');
    }
    
    public function latestHistory()
    {
        return $this->hasOne(ShipmentHistory::class, 'shipment_id')
            ->latestOfMany();
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
