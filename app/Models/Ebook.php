<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Ebook extends Model
{
    use HasUuids;

    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'description',
        'price',
        'file_path',
        'cover_image',
        'is_published'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
