<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateUserroleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('userrole', function (Blueprint $table) {
            $table->unsignedSmallInteger('userole_id')->primary();
            $table->string('userole_name');
        });

        DB::table('userrole')->insert([
            ['userole_id' => 1, 'userole_name' => 'Bibliotecário'],
            ['userole_id' => 2, 'userole_name' => 'Aluno']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('userrole');
    }
}
