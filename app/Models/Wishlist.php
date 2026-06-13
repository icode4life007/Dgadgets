<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'product_id',
        'session_id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Get the user that owns the wishlist item.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the product in the wishlist.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Scope a query to only include items for a specific session.
     */
    public function scopeBySession($query, $sessionId)
    {
        return $query->where('session_id', $sessionId);
    }

    /**
     * Scope a query to only include items for a specific user.
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope a query to only include items for current user/session.
     */
    public function scopeForCurrentUser($query, $userId = null, $sessionId = null)
    {
        if ($userId) {
            return $query->where('user_id', $userId);
        }
        
        return $query->where('session_id', $sessionId);
    }

    /**
     * Check if a product is in wishlist for current user/session.
     */
    public static function isInWishlist($productId, $userId = null, $sessionId = null)
    {
        return self::where('product_id', $productId)
            ->when($userId, function($query) use ($userId) {
                return $query->where('user_id', $userId);
            })
            ->when(!$userId && $sessionId, function($query) use ($sessionId) {
                return $query->where('session_id', $sessionId);
            })
            ->exists();
    }

    /**
     * Get wishlist count for current user/session.
     */
    public static function getCount($userId = null, $sessionId = null)
    {
        return self::when($userId, function($query) use ($userId) {
                return $query->where('user_id', $userId);
            })
            ->when(!$userId && $sessionId, function($query) use ($sessionId) {
                return $query->where('session_id', $sessionId);
            })
            ->count();
    }

    /**
     * Migrate guest wishlist items to user after login.
     */
    public static function migrateGuestWishlist($sessionId, $userId)
    {
        // Get all guest wishlist items
        $guestItems = self::where('session_id', $sessionId)->get();

        foreach ($guestItems as $item) {
            // Check if item already exists for user
            $exists = self::where('user_id', $userId)
                ->where('product_id', $item->product_id)
                ->exists();

            if (!$exists) {
                // Transfer item to user
                $item->update([
                    'user_id' => $userId,
                    'session_id' => null
                ]);
            } else {
                // Delete duplicate guest item
                $item->delete();
            }
        }
    }
}