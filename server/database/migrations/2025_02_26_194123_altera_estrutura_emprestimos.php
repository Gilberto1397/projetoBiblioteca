<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AlteraEstruturaEmprestimos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans_books', function (Blueprint $table) {
            $table->id('loans_books_id');
            $table->unsignedBigInteger('loans_books_loan_id');
            $table->unsignedBigInteger('loans_books_book_id');

            $table->foreign('loans_books_loan_id')
                ->references('loan_id')
                ->on('loans')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('loans_books_book_id')
                ->references('book_id')
                ->on('books')
                ->onDelete('no action')
                ->onUpdate('no action');
        });

        DB::unprepared(
            'INSERT INTO loans_books (loans_books_loan_id, loans_books_book_id) SELECT loan_id, loan_book_id FROM loans;'
        );

        Schema::table('loans', function (Blueprint $table) {
            $table->dropColumn('loan_book_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->unsignedBigInteger('loan_book_id')->nullable();

            $table->foreign('loan_book_id')
                ->references('book_id')
                ->on('books')
                ->onDelete('no action')
                ->onUpdate('no action');
        });

        DB::unprepared(
            'UPDATE loans SET loan_book_id = loans_books.loans_books_id from loans_books where loans.loan_id = loans_books.loans_books_loan_id;'
        );

        DB::unprepared('ALTER TABLE loans ALTER COLUMN loan_book_id SET NOT NULL;');

        Schema::dropIfExists('loans_books');
    }
}
