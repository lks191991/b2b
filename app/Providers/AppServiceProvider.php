<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
 use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Types\StringType;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
	 
	


    public function boot()
    {
		if (!Type::hasType('enum')) {
        Type::addType('enum', StringType::class);
		}
        Paginator::useBootstrap();
    }
}
