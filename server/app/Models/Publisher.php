<?php

namespace App\Models;

use Database\Factories\PublisherFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $publisher_id
 * @property string $publisher_name
 * @property string $publisher_country_origin
 */
class Publisher extends Model
{
    protected $table = 'publishers';
    protected $primaryKey = 'publisher_id';
    public $timestamps = false;

    use HasFactory;

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return PublisherFactory::new();
    }

    public function books()
    {
        return $this->belongsToMany(
            Book::class,
            'publishers_books',
            'publisher_id',
            'book_id'
        );
    }
}
