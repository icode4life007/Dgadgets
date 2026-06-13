<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'customer_name',
        'customer_phone',
        'customer_email',
        'customer_address',
        'shipping_address',
        'notes',
        'subtotal',
        'total',
        'total_amount',
        'status',
        'payment_status',
        'payment_method',
        'tracking_number',
        'courier_service',
        'estimated_delivery',
        'delivered_at',
        'admin_notes'
    ];

    protected $casts = [
        'estimated_delivery' => 'date',
        'delivered_at' => 'datetime',
        'subtotal' => 'decimal:2',
        'total' => 'decimal:2'
    ];

    const STATUSES = [
        'pending' => 'Pending',
        'processing' => 'Processing',
        'confirmed' => 'Confirmed',
        'packed' => 'Packed',
        'shipped' => 'Shipped',
        'in_transit' => 'In Transit',
        'out_for_delivery' => 'Out for Delivery',
        'delivered' => 'Delivered',
        'cancelled' => 'Cancelled',
        'refunded' => 'Refunded'
    ];

    const PAYMENT_STATUSES = [
        'pending' => 'Pending',
        'paid' => 'Paid',
        'failed' => 'Failed',
        'refunded' => 'Refunded'
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function trackings()
    {
        return $this->hasMany(OrderTracking::class)->orderBy('tracked_at', 'desc');
    }

    

    public function latestTracking()
    {
        return $this->hasOne(OrderTracking::class)->latest('tracked_at');
    }

    public function getStatusBadgeAttribute()
{
    $status = $this->status;
    $label = self::STATUSES[$status] ?? ucfirst($status);
    
    $badges = [
        'pending' => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 border border-yellow-200">
                        <i class="fas fa-clock mr-1 text-yellow-600"></i>Pending
                      </span>',
        'processing' => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 border border-blue-200">
                          <i class="fas fa-sync-alt mr-1 text-blue-600"></i>Processing
                        </span>',
        'confirmed' => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 border border-indigo-200">
                          <i class="fas fa-check-circle mr-1 text-indigo-600"></i>Confirmed
                        </span>',
        'packed' => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 border border-purple-200">
                      <i class="fas fa-box mr-1 text-purple-600"></i>Packed
                    </span>',
        'shipped' => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-cyan-100 text-cyan-800 border border-cyan-200">
                        <i class="fas fa-shipping-fast mr-1 text-cyan-600"></i>Shipped
                      </span>',
        'in_transit' => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800 border border-orange-200">
                          <i class="fas fa-truck mr-1 text-orange-600"></i>In Transit
                        </span>',
        'out_for_delivery' => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800 border border-amber-200">
                                <i class="fas fa-road mr-1 text-amber-600"></i>Out for Delivery
                              </span>',
        'delivered' => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                          <i class="fas fa-check-circle mr-1 text-green-600"></i>Delivered
                        </span>',
        'cancelled' => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 border border-red-200">
                          <i class="fas fa-times-circle mr-1 text-red-600"></i>Cancelled
                        </span>',
        'refunded' => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 border border-gray-200">
                        <i class="fas fa-undo-alt mr-1 text-gray-600"></i>Refunded
                       </span>'
    ];
    
    return $badges[$status] ?? '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 border border-gray-200">' . $label . '</span>';
}

    public function getPaymentStatusBadgeAttribute()
{
    $status = $this->payment_status;
    $label = ucfirst($status);
    
    $badges = [
        'pending' => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 border border-yellow-200">
                        <i class="fas fa-clock mr-1 text-yellow-600"></i>Pending
                      </span>',
        'paid' => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                    <i class="fas fa-check-circle mr-1 text-green-600"></i>Paid
                  </span>',
        'failed' => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 border border-red-200">
                      <i class="fas fa-exclamation-circle mr-1 text-red-600"></i>Failed
                    </span>',
        'refunded' => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 border border-gray-200">
                        <i class="fas fa-undo-alt mr-1 text-gray-600"></i>Refunded
                       </span>'
    ];
    
    return $badges[$status] ?? '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 border border-gray-200">' . $label . '</span>';
}

    public function getProgressPercentageAttribute()
    {
        $progress = [
            'pending' => 10,
            'processing' => 20,
            'confirmed' => 30,
            'packed' => 40,
            'shipped' => 50,
            'in_transit' => 60,
            'out_for_delivery' => 80,
            'delivered' => 100,
            'cancelled' => 0,
            'refunded' => 0
        ];

        return $progress[$this->status] ?? 0;
    }

    public function scopeSearch($query, $term)
    {
        return $query->where(function($q) use ($term) {
            $q->where('order_number', 'LIKE', "%{$term}%")
              ->orWhere('customer_name', 'LIKE', "%{$term}%")
              ->orWhere('customer_phone', 'LIKE', "%{$term}%")
              ->orWhere('tracking_number', 'LIKE', "%{$term}%");
        });
    }
}