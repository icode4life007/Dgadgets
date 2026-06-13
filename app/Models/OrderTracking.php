<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderTracking extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'status',
        'location',
        'description',
        'tracked_at'
    ];

    protected $casts = [
        'tracked_at' => 'datetime'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function getStatusBadgeAttribute()
    {
        $colors = [
            'pending' => 'yellow',
            'processing' => 'blue',
            'confirmed' => 'indigo',
            'packed' => 'purple',
            'shipped' => 'cyan',
            'in_transit' => 'orange',
            'out_for_delivery' => 'amber',
            'delivered' => 'green',
            'cancelled' => 'red',
            'refunded' => 'gray'
        ];

        $color = $colors[$this->status] ?? 'gray';
        
        return "<span class='px-2 py-1 bg-{$color}-100 text-{$color}-800 text-xs rounded-full'>" . Order::STATUSES[$this->status] . "</span>";
    }
}