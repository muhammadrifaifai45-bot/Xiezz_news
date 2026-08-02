<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class News extends Model
{
    protected $fillable = [
        'author_id',
        'news_category_id',
        'title',
        'slug',
        'thumbnail',
        'content',
        'is_featured'

    ];

    public function Author(){
        return $this->belongsTo(Author::class);
    }

    public function newsCategory(){
        return $this->belongsTo(NewsCategory::class);
}
}
