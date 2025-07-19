<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePublishersBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publishers_books', function (Blueprint $table) {
            $table->id('publishers_books_id');
            $table->unsignedBigInteger('publisher_id');
            $table->unsignedBigInteger('book_id');

            $table->foreign('publisher_id')
                ->references('publisher_id')
                ->on('publishers')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('book_id')
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
        Schema::dropIfExists('publishers_books');
    }
}
