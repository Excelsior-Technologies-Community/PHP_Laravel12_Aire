<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'sku',
        'price',
        'category',
        'stock',
        'status',
        'is_featured',
        'description',
        'custom_fields',
        'images',
        'cover_image',
        'variants',
        'validation_rules',
    ];

    protected $casts = [
        'price' => 'integer',
        'stock' => 'integer',
        'is_featured' => 'boolean',
        'custom_fields' => 'array',
        'images' => 'array',
        'variants' => 'array',
        'validation_rules' => 'array',
    ];

    /**
     * Inventory value for one product.
     */
    public function getInventoryValueAttribute()
    {
        return $this->price * $this->stock;
    }

    /**
     * Check whether product is low in stock.
     */
    public function getIsLowStockAttribute()
    {
        return $this->stock > 0 &&
            $this->stock <= 5;
    }

    /**
     * Check whether product is out of stock.
     */
    public function getIsOutOfStockAttribute()
    {
        return $this->stock == 0;
    }
}
