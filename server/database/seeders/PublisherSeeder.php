<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Publisher;
use Illuminate\Database\Seeder;

class PublisherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Publisher::factory()->count(10)->has(Book::factory(5))->create();
    }
}
