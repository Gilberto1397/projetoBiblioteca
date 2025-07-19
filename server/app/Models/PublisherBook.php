<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $publishers_books_id
 * @property integer $publisher_id
 * @property integer $book_id
 */
class PublisherBook extends Model
{
    use HasFactory;

    protected $table = 'publishers_books';

    protected $primaryKey = 'publishers_books_id';

    public $timestamps = false;
}
