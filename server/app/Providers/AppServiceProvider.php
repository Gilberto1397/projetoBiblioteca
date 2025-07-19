<?php

namespace App\Providers;

use App\Repositories\Author\AuthorRepository;
use App\Repositories\Author\AuthorRepositoryEloquent;
use App\Repositories\Book\BookRepository;
use App\Repositories\Book\BookRepositoryEloquent;
use App\Repositories\Gender\GenderRepository;
use App\Repositories\Gender\GenderRepositoryEloquent;
use App\Repositories\Loan\LoanRepository;
use App\Repositories\Loan\LoanRepositoryEloquent;
use App\Repositories\Publisher\PublisherRepository;
use App\Repositories\Publisher\PublisherRepositoryEloquent;
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRepositoryEloquent;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public array $bindings = [
        GenderRepository::class => GenderRepositoryEloquent::class,
        PublisherRepository::class => PublisherRepositoryEloquent::class,
        AuthorRepository::class => AuthorRepositoryEloquent::class,
        UserRepository::class => UserRepositoryEloquent::class,
        BookRepository::class => BookRepositoryEloquent::class,
        LoanRepository::class => LoanRepositoryEloquent::class,
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
