<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'subcategory_id',
        'name',
        'sku',
        'short_description',
        'description',
        'fabric',
        'season',
        'tags',
        'mrp',
        'discount_percent',
        'selling_price',
        'stock_quantity',
        'low_stock_threshold',
        'sizes',
        'colors',
        'main_image',
        'status',
    ];

    protected $casts = [
        'sizes' => 'array',
        'colors' => 'array',
        'mrp' => 'decimal:2',
        'discount_percent' => 'decimal:2',
        'selling_price' => 'decimal:2',
    ];

    /**
     * Category Relationship
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Sub Category Relationship
     */
    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class, 'subcategory_id');
    }

    /**
     * Product Images
     */
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
}