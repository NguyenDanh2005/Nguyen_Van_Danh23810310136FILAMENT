<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'sv23810310136_products';
    protected $fillable = [
        'category_id', 'name', 'slug', 'description',
        'price', 'stock_quantity', 'image_path', 'status', 'brand_origin'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}