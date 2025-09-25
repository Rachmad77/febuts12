<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class ProgramStudi extends Model
{
    use HasFactory, SoftDeletes;

    protected $table        = 'program_studi';
    protected $primaryKey   = 'id';
    protected $fillable     = [
        'name'
    ];


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($ProgramStudi) {
            $ProgramStudi->slug = static::generateUniqueSlug($ProgramStudi->name);
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
