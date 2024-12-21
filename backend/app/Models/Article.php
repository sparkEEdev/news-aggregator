<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'title',
        'description',
        'content',
        'url',
        'author',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function source()
    {
        return $this->belongsToMany(Category::class, 'source_article', 'article_id', 'source_id');
    }

    public function category()
    {
        return $this->belongsToMany(Category::class, 'article_category', 'article_id', 'category_id');
    }
}
