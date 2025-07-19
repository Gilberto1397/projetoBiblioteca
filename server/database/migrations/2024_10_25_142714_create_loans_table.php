<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id('loan_id');
            $table->date('loan_date');
            $table->date('loan_expected_return_date');
            $table->date('loan_true_return_date')->nullable();
            $table->decimal('loan_forfeit', 6, 2)->nullable();
            $table->unsignedBigInteger('loan_user_id');
            $table->unsignedBigInteger('loan_book_id');

            $table->foreign('loan_user_id')
                ->references('user_id')
                ->on('users')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('loan_book_id')
                ->references('book_id')
                ->on('books')
                ->onDelete('no action')
                ->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loan');
    }
}
