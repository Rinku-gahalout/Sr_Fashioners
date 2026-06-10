<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected $table = 'sub_categories';

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'image',
        'status',
        'sort_order',
    ];

    /**
     * Parent Category
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
