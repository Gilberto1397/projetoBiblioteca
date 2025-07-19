<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $loan_id
 * @property DateTime $loan_date
 * @property DateTime $loan_expected_return_date
 * @property DateTime $loan_true_return_date
 * @property float $loan_forfeit
 * @property integer $loan_user_id
 * @property Book[] $books
 */
class Loan extends Model
{
    use HasFactory;

    protected $table = 'loans';

    protected $primaryKey = 'loan_id';

    public $timestamps = false;

    protected $fillable = [
        'loan_date',
        'loan_expected_return_date',
        'loan_true_return_date',
        'loan_forfeit',
        'loan_user_id'
    ];

    public function books()
    {
        return $this->belongsToMany(
            Book::class,
            'loans_books',
            'loans_books_loan_id',
            'loans_books_book_id'
        );
    }
}
