<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableRegistrorotassolicitadas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registerrequestedroutes', function (Blueprint $table) {
            $table->id('id_request');
            $table->string('route');
            $table->string('method');
            $table->unsignedBigInteger('user_requesting')->nullable();
            $table->string('host_request');
            $table->string('user_agent');
            $table->timestamp('date_request');

            $table
                ->foreign('user_requesting')
                ->references('user_id')
                ->on('users')
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
        Schema::dropIfExists('registerrequestedroutes');
    }
}
