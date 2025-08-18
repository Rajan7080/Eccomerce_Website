<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;
    protected $table = "categories";
    protected $fillable = ['name', 'parent_id'];

    // Parent category relationship
    public function parent()
    {
        return $this->belongsTo(Categories::class, 'parent_id');
    }

    // Child categories relationship
    public function children()
    {
        return $this->hasMany(Categories::class, 'parent_id');
    }
    public function categories()
    {
        return $this->hasMany(Products::class, 'category_id');
    }
}
