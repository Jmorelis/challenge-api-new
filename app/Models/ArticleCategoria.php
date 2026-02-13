<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class articles_category extends Model
{
    use HasFactory;

    protected $table = 'articles_category';

    protected $fillable = [
       'article_id',
        'category_id',
    ];

  
}