<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Propriety extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'province_id',
        'category_propriety_id',
        'title',
        'description',
        'price',
        'location_detail',
        'bedrooms',
        'bathrooms',
        'area',
        'deal_type',
        'image',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function categoryPropriety()
    {
        return $this->belongsTo(CategoryPropriety::class);
    }
}
