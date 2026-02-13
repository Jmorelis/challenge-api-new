<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Categories extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
       'name',
        'description',
        'status',
        
    ];

    public function articles()
    {
        
        return $this->belongsToMany(Article::class);
    }
}

