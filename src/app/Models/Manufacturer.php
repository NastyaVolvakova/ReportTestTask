<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manufacturer extends Model
{
    use HasFactory;

    protected $primaryKey = 'manufacturer_id';
    protected $keyType = 'int';

    protected $fillable = [
        'manufacturer_id',
        'manufacturer_name',
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'manufacturer_id', 'manufacturer_id');
    }
}
