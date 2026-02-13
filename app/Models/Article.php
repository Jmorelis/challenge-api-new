<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasFactory;

    protected $table = 'articles';

    protected $fillable = [
       'title',
        'content',
        'slug',
        'status',
        'published_at',
        'user_id',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($article) {

            $baseSlug = Str::slug($article->title);
            $slug = $baseSlug;
            $counter = 1;

            while (self::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $counter++;
            }

            $article->slug = $slug;
        });
    }

    public function categories()
    {
        return $this->belongsToMany(Categories::class, 'article_category', 'article_id', 'category_id');
    }

    public function user() 
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

