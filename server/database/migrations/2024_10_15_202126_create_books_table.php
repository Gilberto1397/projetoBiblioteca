<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id('book_id');
            $table->string('book_title', 255);
            $table->string('book_isbn');
            $table->date('book_publication_date');
            $table->integer('book_in_stock');
            $table->integer('book_amount_borrowed')->default(0);
            $table->integer('book_author_id');
            $table->integer('book_gender_id');

            $table->foreign('book_author_id')
                ->references('author_id')
                ->on('authors')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('book_gender_id')
                ->references('gender_id')
                ->on('genres')
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
        Schema::dropIfExists('books');
    }
}
