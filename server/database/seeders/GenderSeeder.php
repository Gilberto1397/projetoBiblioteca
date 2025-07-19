<?php

namespace Database\Seeders;

use App\Models\Gender;
use Illuminate\Database\Seeder;

class GenderSeeder extends Seeder
{
    const GENRES = [
        'Ação', 'Aventura', 'Cinema de arte', 'Chanchada', 'Comédia', 'Comédia de ação', 'Comédia de terror', 'Comédia dramática', 'Comédia romântica', 'Dança', 'Documentário', 'Docuficção', 'Drama', 'Espionagem', 'Faroeste', 'Fantasia', 'Fantasia científica', 'Ficção científica', 'Filmes com truques', 'Filmes de guerra', 'Mistério', 'Musical', 'Filme policial', 'Romance', 'Terror', 'Thriller'
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $genres = [];

        foreach (self::GENRES as $genre) {
            $genres[] = ['gender_name' => $genre];
        }

        Gender::insert($genres);
    }
}
