<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'name',
        'description',
        'url',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'source_category', 'source_id', 'category_id');
    }
}
