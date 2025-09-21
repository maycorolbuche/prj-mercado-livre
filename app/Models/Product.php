<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'category_id',
        'attributes',
        'ml_item_id',
        'ml_status',
        'ml_response'
    ];

    protected $casts = [
        'attributes' => 'array',
        'ml_response' => 'array',
    ];
}
