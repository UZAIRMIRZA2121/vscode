<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelatedProduct extends Model
{
    use HasFactory;
    protected $fillable = [
        'main_product_id',
        'related_product_id',
        'relation_type',
    ];
}
