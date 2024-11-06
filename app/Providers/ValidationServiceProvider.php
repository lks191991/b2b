<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

use App\HelpContent;

class ValidationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('sanitizeScripts', function ($attribute, $value, $parameters, $validator) {
			//$inputs = $validator->getData();
			
			if($value != '') {
				$decoded_val = htmlspecialchars_decode($value);
				
				if(strpos($value, "<script") === false && strpos($decoded_val, "<script") === false && strpos($value, "<iframe") === false && strpos($decoded_val, "<iframe") === false && strpos($decoded_val, "?") === false && strpos($decoded_val, '"') === false){
					return true;
				}
			}
			return false;
		});
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
