<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    use HasFactory;

    protected $primaryKey = 'price_id';
    protected $keyType = 'int';
    protected $fillable = [
        'price_id',
        'product_id',
        'price',
        'price_date',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
}
