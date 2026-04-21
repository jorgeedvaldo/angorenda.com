<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Property extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'description',
        'price',
        'currency',
        'bedrooms',
        'bathrooms',
        'area',
        'purpose',
        'property_type',
        'address',
        'city',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
        'bedrooms' => 'integer',
        'bathrooms' => 'integer',
        'area' => 'float',
    ];

    /**
     * Boot the model and register auto-slug generation.
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Property $property): void {
            if (empty($property->slug)) {
                $property->slug = static::generateUniqueSlug($property->title);
            }
        });

        static::updating(function (Property $property): void {
            if ($property->isDirty('title') && !$property->isDirty('slug')) {
                $property->slug = static::generateUniqueSlug($property->title, $property->id);
            }
        });
    }

    /**
     * Generate a unique slug for the property.
     */
    protected static function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $count = 1;

        $query = static::where('slug', $slug);
        if ($ignoreId) {
            $query->where('id', '!=', $ignoreId);
        }

        while ($query->exists()) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
            $query = static::where('slug', $slug);
            if ($ignoreId) {
                $query->where('id', '!=', $ignoreId);
            }
        }

        return $slug;
    }

    /**
     * Get the user that owns the property.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the images for the property.
     */
    public function images(): HasMany
    {
        return $this->hasMany(PropertyImage::class);
    }

    /**
     * Get the first image (main image) for the property.
     */
    public function getMainImageAttribute(): ?PropertyImage
    {
        return $this->images->first();
    }

    /**
     * Get formatted price with currency.
     */
    public function getFormattedPriceAttribute(): string
    {
        return $this->currency . ' ' . number_format((float) $this->price, 2, ',', ' ');
    }

    /**
     * Get the purpose label in Portuguese.
     */
    public function getPurposeLabelAttribute(): string
    {
        return match ($this->purpose) {
            'sale' => 'À venda',
            'rent' => 'Para arrendar',
            default => $this->purpose,
        };
    }
}
