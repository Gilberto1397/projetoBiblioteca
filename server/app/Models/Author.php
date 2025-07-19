<?php

namespace App\Models;

use Database\Factories\AuthorFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $author_id
 * @property string $author_name
 * @property string $author_nationality
 * @property \DateTime $author_date_birth
 */
class Author extends Model
{
    use HasFactory;

    protected $table = 'authors';
    protected $primaryKey = 'author_id';
    public $timestamps = false;

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return AuthorFactory::new();
    }
}
