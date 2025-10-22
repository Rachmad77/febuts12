<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class TagCategory extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'tag_categories';
    protected $fillable = ['name', 'slug'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($tagCategory){
            $tagCategory->slug = Str::slug($tagCategory->name);
        });

        static::updating(function($tagCategory){
            $tagCategory->slug = Str::slug($tagCategory->name);
        });
    }

    public function blogs()
    {
        return $this->belongsToMany(Blog::class, 'blog_tag', 'tag_category_id', 'blog_id');
    }
}
