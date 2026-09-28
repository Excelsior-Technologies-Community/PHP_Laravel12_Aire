<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'price',
        'category',
        'stock',
        'status',
        'is_featured',
        'description',
    ];

    protected $casts = [
        'price' => 'integer',
        'stock' => 'integer',
        'is_featured' => 'boolean',
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
