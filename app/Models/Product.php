<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'desc',
        'pres',
        'img',
        'qty',
        'price',
        'discount',
        'formula',
        'category_id',
        'related_product_id',
        'qr_code'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
