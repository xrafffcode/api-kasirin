<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'image',
        'barcode',
        'price',
        'stock',
        'status',
        'product_category_id',
    ];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    public function setImageAttribute($value)
    {
        $this->attributes['image'] = $value->store('images', 'public');
    }

    public function getImageAttribute($value)
    {
        return asset('storage/' . $value);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopeInactive($query)
    {
        return $query->where('status', 0);
    }

    public function scopeStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    public function scopeOutOfStock($query)
    {
        return $query->where('stock', 0);
    }

    public function scopeCategory($query, $category)
    {
        return $query->where('product_category_id', $category);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', '%' . $search . '%');
    }
}
