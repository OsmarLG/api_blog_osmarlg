<?php

namespace App\Providers;

use App\Interfaces\PostRepositoryInterface;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;
use App\Interfaces\UserRepositoryInterface;
use App\Repositories\PostRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
    
        $this->app->bind(PostRepositoryInterface::class, PostRepository::class);
    }
    

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
