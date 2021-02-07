<?php

namespace App\Providers;

use App\Contracts\BrandContract;
use App\Contracts\OrderContract;
use App\Contracts\ProductContract;
use App\Contracts\CategoryContract;
use App\Contracts\AttributeContract;
use App\Contracts\BranchContract;
use App\Contracts\ItemContract;
use App\Contracts\UserContract;
use App\Repositories\BrandRepository;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\CategoryRepository;
use App\Repositories\AttributeRepository;
use App\Repositories\BranchRepository;
use App\Repositories\ItemRepository;
use Laravel\Passport\Bridge\UserRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    protected $repositories = [
        CategoryContract::class         =>          CategoryRepository::class,
        AttributeContract::class        =>          AttributeRepository::class,
        BrandContract::class            =>          BrandRepository::class,
        ProductContract::class          =>          ProductRepository::class,
        OrderContract::class            =>          OrderRepository::class,
        UserContract::class             =>          UserRepository::class,
        ItemContract::class             =>          ItemRepository::class,
        BranchContract::class           =>          BranchRepository::class,

    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        foreach ($this->repositories as $interface => $implementation)
        {
            $this->app->bind($interface, $implementation);
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
