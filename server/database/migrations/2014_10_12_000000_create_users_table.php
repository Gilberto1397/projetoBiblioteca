<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id');
            $table->string('user_name', 255);
            $table->string('user_cpf', 11);
            $table->string('user_email', 255)->unique();
            $table->timestamp('user_email_verified_at')->nullable();
            $table->string('user_password', 255);
            $table->string('user_telephone', 11)->nullable();
            $table->date('user_date_birth');
            $table->date('user_register_last_update');
            $table->boolean('user_register_active');
            $table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
