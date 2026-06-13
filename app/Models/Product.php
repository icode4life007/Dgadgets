<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use App\Models\Review;
use Spatie\Sluggable\SlugOptions;

class Product extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = [
        'name',
        'slug',
        'category_id',
        'brand',
        'model',
        'description',
        'price',
        'tax',
        'quantity',
        'main_image',
        'gallery_images',
        'specifications',
        'is_hot_deal',
        'is_new_arrival',
        'is_featured',
        'is_active'
    ];

    protected $casts = [
        'gallery_images' => 'array',
        'specifications' => 'array',
        'is_hot_deal' => 'boolean',
        'is_new_arrival' => 'boolean',
        'is_featured' => 'boolean',
        'is_active' => 'boolean'
    ];

    /**
     * Get the gallery images attribute
     */
    public function getGalleryImagesAttribute($value)
    {
        // If it's already an array from the cast, return it
        if (is_array($value)) {
            return $value;
        }

        // If it's null or empty
        if (empty($value)) {
            return [];
        }

        // If it's a string, try to decode it
        if (is_string($value)) {
            // Remove any extra quotes if present
            $cleaned = trim($value, '"\'');

            // Try to decode
            $decoded = json_decode($cleaned, true);

            // If decode fails, try to handle double-encoded JSON
            if (!is_array($decoded)) {
                // Maybe it's double-encoded?
                $doubleDecoded = json_decode($cleaned, true);
                if (is_array($doubleDecoded)) {
                    return $doubleDecoded;
                }

                // If it's still not an array, maybe it's a comma-separated string?
                if (str_contains($cleaned, ',')) {
                    return array_map('trim', explode(',', $cleaned));
                }

                // If all else fails, return as single-item array
                return [$cleaned];
            }

            return $decoded;
        }

        return [];
    }

    /**
     * Set the gallery images attribute - FIXED VERSION
     */
    public function setGalleryImagesAttribute($value)
    {
        // If it's null or empty
        if (is_null($value) || $value === '') {
            $this->attributes['gallery_images'] = null;
            return;
        }

        // If it's already a JSON string, check if it's valid
        if (is_string($value) && $this->isJson($value)) {
            $this->attributes['gallery_images'] = $value;
            return;
        }

        // If it's an array, encode to JSON
        if (is_array($value)) {
            $this->attributes['gallery_images'] = json_encode($value);
            return;
        }

        // If it's a string that might be a serialized array, try to decode
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            if (is_array($decoded)) {
                $this->attributes['gallery_images'] = json_encode($decoded);
                return;
            }
        }

        // Default: set as null
        $this->attributes['gallery_images'] = null;
    }

    /**
     * Check if a string is valid JSON
     */
    private function isJson($string)
    {
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }

    /**
     * Check if there are gallery images
     */
    public function hasGalleryImages(): bool
    {
        $images = $this->gallery_images;
        return is_array($images) && count($images) > 0;
    }

    /**
     * Get safe gallery images
     */
    public function getSafeGalleryImages(): array
    {
        $images = $this->gallery_images;
        return is_array($images) ? $images : [];
    }

    /**
     * Get the reviews for this product
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Get approved reviews
     */
    public function approvedReviews()
    {
        return $this->hasMany(Review::class)->where('is_approved', true);
    }

    /**
     * Get average rating attribute
     */
    public function getAverageRatingAttribute()
    {
        return $this->approvedReviews()->avg('rating') ?? 0;
    }

    /**
 * Get safe gallery images array
 */
/**
 * Get safe gallery images array
 */
public function getSafeGalleryImagesAttribute()
{
    if ($this->gallery_images) {
        if (is_string($this->gallery_images)) {
            return json_decode($this->gallery_images, true) ?? [];
        }
        if (is_array($this->gallery_images)) {
            return $this->gallery_images;
        }
    }
    return [];
}

    /**
     * Get rating count attribute
     */
    public function getRatingCountAttribute()
    {
        return $this->approvedReviews()->count();
    }

    /**
     * Get rating distribution
     */
    public function getRatingDistributionAttribute()
    {
        $distribution = [
            1 => 0,
            2 => 0,
            3 => 0,
            4 => 0,
            5 => 0
        ];

        $ratings = $this->approvedReviews()
            ->selectRaw('rating, count(*) as count')
            ->groupBy('rating')
            ->pluck('count', 'rating')
            ->toArray();

        return array_merge($distribution, $ratings);
    }

    /**
     * Get the slug options
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    /**
     * Get the category that owns the product
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the final price including tax
     */
    public function getFinalPriceAttribute()
    {
        return $this->price + ($this->price * $this->tax / 100);
    }

    /**
     * Get WhatsApp link for this product - MODIFIED TO MATCH YOUR FORMAT
     */
    public function getWhatsAppLinkAttribute()
    {
        $message = $this->generateWhatsAppMessage();
        return 'https://wa.me/2348000000000?text=' . urlencode($message);
    }

    /**
     * Generate WhatsApp message in the requested format
     */
    public function generateWhatsAppMessage($quantity = 1)
    {
        $subtotal = $this->price * $quantity;
        $productUrl = route('product', $this->slug);
        
        $message = "*DOMINION GADGET & ACCESSORIES PURCHASE* \n\n";
        
        $message .= "━━━━━━━━━━━━━━━━━━━━━ *MY NEW ORDER DETAILS* ━━━━━━━━━━━━━━━━━ \n";
        $message .= "Item Purchases: {$this->name}\n";
        $message .= "Qty: {$quantity}\n";
        $message .= "Price: ₦" . number_format($this->price, 0) . "\n";
        $message .= "Subtotal: ₦" . number_format($subtotal, 0) . " \n";
        $message .= "Purchased Item: {$productUrl} \n\n";
        
        $message .= "━━━━━━━━━━━━━━━━━━━━━ *SUMMARY* ━━━━━━━━━━━━━━━━━ \n";
        $message .= "Total Items: {$quantity}\n";
        $message .= "Other Products Purchased: None\n";
        $message .= "Subtotal: ₦" . number_format($subtotal, 0) . " \n";
        $message .= "Delivery Fee: To be calculated\n\n";
        
        $message .= "TOTAL AMOUNT: ₦" . number_format($subtotal, 0) . "\n\n";
        
        $message .= "* ━━━━━━━━━━━━━━━━━━━━━ *CUSTOMER INFORMATION* ━━━━━━━━━━━━━━━━━ \n";
        $message .= "Please provide your:\n";
        $message .= " • Full Name: \n";
        $message .= "• Phone Number:\n";
        $message .= " • Delivery Address: \n\n";
        
        $message .= "One of our sales representative will chat you shortly for payment. Once payment has been confirmed, we will dispatch your item(s) with the details you provided (Phone Number and Delivery Address).\n\n";
        
        $message .= "Thank you for shopping with us!";
        
        return $message;
    }

    /**
     * Get WhatsApp link for multiple items (for cart/checkout)
     */
    public static function getWhatsAppLinkForCart($cartItems, $total, $itemCount)
    {
        $message = "*DOMINION GADGET & ACCESSORIES PURCHASE* \n\n";
        
        $message .= "━━━━━━━━━━━━━━━━━━━━━ *MY NEW ORDER DETAILS* ━━━━━━━━━━━━━━━━━ \n";
        
        foreach ($cartItems as $item) {
            $product = $item['product'];
            $productUrl = route('product', $product->slug);
            
            $message .= "Item Purchases: {$product->name}\n";
            $message .= "Qty: {$item['quantity']}\n";
            $message .= "Price: ₦" . number_format($product->price, 0) . "\n";
            $message .= "Subtotal: ₦" . number_format($item['subtotal'], 0) . " \n";
            $message .= "Purchased Item: {$productUrl} \n\n";
        }
        
        $message .= "━━━━━━━━━━━━━━━━━━━━━ *SUMMARY* ━━━━━━━━━━━━━━━━━ \n";
        $message .= "Total Items: {$itemCount}\n";
        
        if (count($cartItems) > 1) {
            $otherProducts = count($cartItems) - 1;
            $message .= "Other Products Purchased: {$otherProducts} other item(s)\n";
        } else {
            $message .= "Other Products Purchased: None\n";
        }
        
        $message .= "Subtotal: ₦" . number_format($total, 0) . " \n";
        $message .= "Delivery Fee: To be calculated\n\n";
        
        $message .= "TOTAL AMOUNT: ₦" . number_format($total, 0) . "\n\n";
        
        $message .= "* ━━━━━━━━━━━━━━━━━━━━━ *CUSTOMER INFORMATION* ━━━━━━━━━━━━━━━━━ \n";
        $message .= "Please provide your:\n";
        $message .= " • Full Name: \n";
        $message .= "• Phone Number:\n";
        $message .= " • Delivery Address: \n\n";
        
        $message .= "One of our sales representative will chat you shortly for payment. Once payment has been confirmed, we will dispatch your item(s) with the details you provided (Phone Number and Delivery Address).\n\n";
        
        $message .= "Thank you for shopping with us!";
        
        return 'https://wa.me/2348000000000?text=' . urlencode($message);
    }

    /**
     * Scope filter
     */
    public function scopeFilter($query, array $filters)
    {
        // Category filter
        if (!empty($filters['category'])) {
            $query->whereHas('category', function ($q) use ($filters) {
                $q->where('slug', $filters['category']);
            });
        }

        // Price range filter
        if (!empty($filters['min_price']) && !empty($filters['max_price'])) {
            $query->whereBetween('price', [$filters['min_price'], $filters['max_price']]);
        }

        // Tag/Brand filter
        if (!empty($filters['tag'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('brand', 'LIKE', "%{$filters['tag']}%")
                    ->orWhere('model', 'LIKE', "%{$filters['tag']}%")
                    ->orWhere('name', 'LIKE', "%{$filters['tag']}%");
            });
        }

        // Search query
        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'LIKE', "%{$filters['search']}%")
                    ->orWhere('description', 'LIKE', "%{$filters['search']}%")
                    ->orWhere('brand', 'LIKE', "%{$filters['search']}%")
                    ->orWhere('model', 'LIKE', "%{$filters['search']}%");
            });
        }

        return $query;
    }

    /**
     * Scope sort
     */
    public function scopeSort($query, $sortBy = 'default')
    {
        switch ($sortBy) {
            case 'popularity':
                return $query->orderBy('views', 'desc');
            case 'rating':
                return $query->orderBy('views', 'desc');
            case 'latest':
                return $query->orderBy('created_at', 'desc');
            case 'price_low':
                return $query->orderBy('price', 'asc');
            case 'price_high':
                return $query->orderBy('price', 'desc');
            default:
                return $query->orderBy('created_at', 'desc');
        }
    }
}