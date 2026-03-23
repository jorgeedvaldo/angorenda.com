<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryPropriety extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function proprieties()
    {
        return $this->hasMany(Propriety::class);
    }
}
