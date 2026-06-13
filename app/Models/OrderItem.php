<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'product_image', // ADDED - now it exists in table
        'price',
        'quantity',
        'total'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'total' => 'decimal:2'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Accessor for subtotal if needed
    public function getSubtotalAttribute()
    {
        return $this->total;
    }

    // Accessor for full image URL
    public function getImageUrlAttribute()
    {
        return asset($this->product_image);
    }
}