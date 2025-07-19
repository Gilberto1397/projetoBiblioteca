<?php

namespace Feature\Repositories;

use App\Http\Requests\Author\AuthorRequest;
use App\Repositories\Author\AuthorRepositoryEloquent;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class AuthorRepositoryEloquentTest extends TestCase
{
    public function testCreateAuthor()
    {
        DB::beginTransaction();

        $request = new AuthorRequest([
            'name' => 'João Silva',
            'nationality' => 'Brasileiro',
            'dateBirth' => '10/05/1980',
        ]);

        $repository = new AuthorRepositoryEloquent();
        $result = $repository->createAuthor($request);

        $this->assertTrue($result);

        DB::rollBack();
    }
}
