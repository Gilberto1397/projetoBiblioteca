<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $loans_books_id
 * @property int $loans_books_loan_id
 * @property int $loans_books_book_id
 */
class LoanBook extends Model
{
    protected $table = 'loans_books';
    protected $primaryKey = 'loans_books_id';
    public $timestamps = false;
}
