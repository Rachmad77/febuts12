<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Blog extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'blogs';

    protected $fillable = [
        'blog_category_id',
        'title',
        'slug',
        'thumbnail',
        'excerpt',
        'content',
        'status',
        'published_at',
    ];

    protected $dates = ['deleted_at'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function($blog){
            if(empty($blog->slug)){
                $blog->slug = Str::slug($blog->title);
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id');
    }

    public function tags()
    {
        return $this->belongsToMany(TagCategory::class, 'blog_tag', 'blog_id', 'tag_category_id');
    }
}
