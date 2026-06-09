<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrescriptionRequest extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'product_id',
        'img',
        'status',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the product associated with the prescription request.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
