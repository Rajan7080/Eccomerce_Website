<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;
    protected $table = "products";
    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'image',
        'category_id'
    ];
    public function product()
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }
    public function getImagePathAttribute($value)
    {
        return asset('storage/' . $value);
    }
}
