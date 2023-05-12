<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'author_id',
        'isbn',
        'title',
        'description',
        'price',
        'cover_image',
    ];

    protected $searchableFields = ['*'];

    public function author()
    {
        return $this->belongsTo(Author::class);
    }
}
