<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class PageCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table        = 'page_categories';
    protected $primaryKey   = 'id';
    protected $fillable     = [
        'name'
    ];


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($blogCategory) {
            $blogCategory->slug = static::generateUniqueSlug($blogCategory->name);
        });
    }

    protected static function generateUniqueSlug($name)
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $count = 1;

        while (static::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        return $slug;
    }
}
