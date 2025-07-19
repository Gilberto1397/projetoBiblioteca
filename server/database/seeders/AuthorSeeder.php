<?php

namespace Database\Seeders;

use App\Models\Author;
use Database\Factories\AuthorFactory;
use Faker\Factory;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Author::factory(20)->create();
    }
}
