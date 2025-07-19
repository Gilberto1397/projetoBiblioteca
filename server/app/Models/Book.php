<?php

namespace App\Models;

use Database\Factories\BookFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $book_id
 * @property string $book_title
 * @property string $book_isbn
 * @property \DateTime $book_publication_date
 * @property integer $book_in_stock
 * @property integer $book_amount_borrowed
 * @property integer $book_author_id
 * @property integer $book_gender_id
 */
class Book extends Model
{
    use HasFactory;

    protected $table = 'books';

    protected $primaryKey = 'book_id';

    public $timestamps = false;

    protected $fillable = [
        'book_id',
        'book_title',
        'book_isbn',
        'book_publication_date',
        'book_in_stock',
        'book_amount_borrowed',
        'book_author_id',
        'book_gender_id'
    ];

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return BookFactory::new();
    }

    public function author()
    {
        return $this->belongsTo(Author::class, 'book_author_id', 'author_id');
    }

    public function gender()
    {
        return $this->belongsTo(Gender::class, 'book_gender_id', 'gender_id');
    }
}
