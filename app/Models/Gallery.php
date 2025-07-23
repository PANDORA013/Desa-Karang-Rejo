<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'images', 'category', 'type', 'status'
    ];

    protected $casts = [
        'images' => 'array'
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function getThumbnailAttribute(): ?string
    {
        $images = $this->images;
        if (!empty($images) && is_array($images)) {
            return asset('storage/' . $images[0]);
        }
        return asset('images/default-gallery.jpg');
    }
}