<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'barcode',
        'image',
        'cost',
        'price',
        'quantity',
        'description',
        'has_variant',
        'status'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function variant()
    {
        return $this->hasMany(Variant::class);
    }
}
