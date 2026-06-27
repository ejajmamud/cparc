<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $fillable = [
        'name','name_bn','slug','duration_hours','duration_label','duration_label_bn',
        'price','price_note','description','description_bn',
        'features','features_bn','is_featured','is_active','sort_order',
    ];

    protected $casts = [
        'features'    => 'array',
        'features_bn' => 'array',
        'is_featured' => 'boolean',
        'is_active'   => 'boolean',
    ];
}
