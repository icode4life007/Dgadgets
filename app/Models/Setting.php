<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'label',
        'description',
        'sort_order',
        'is_public'
    ];

    protected $casts = [
        'is_public' => 'boolean',
        'sort_order' => 'integer'
    ];

    /**
     * Get setting value with proper type casting
     */
    public function getTypedValueAttribute()
    {
        return match($this->type) {
            'integer' => (int) $this->value,
            'boolean' => (bool) $this->value,
            'json' => json_decode($this->value, true),
            'array' => json_decode($this->value, true),
            default => $this->value
        };
    }

    /**
     * Set setting value with proper type casting
     */
    public function setTypedValueAttribute($value)
    {
        $this->value = match($this->type) {
            'json', 'array' => json_encode($value),
            default => (string) $value
        };
    }
}