<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\URL;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(AuthServiceProvider::class);
        $this->app->register(RepositoryServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        Validator::extend('sum_lte', function ($attribute, $value, $parameters, $validator) {


            $lte = (int) $validator->getData()[$parameters[0]];      # Max value as limit
            $needle = $parameters[1];   # Field name to be sum
            $sum = array_reduce($value, function ($carry, $item) use ($needle) {
                return $carry + $item[$needle];
            }, 0);

            if (isset($parameters[2]) && isset($parameters[3])) {

                 # Aditional foreign data
                $foreignData = (array) $validator->getData()[$parameters[2]];

                # Additional foreign field from data
                $foreignNeedle = $parameters[3];

                $sum = array_reduce($foreignData, function ($carry, $item) use ($foreignNeedle) {
                    return $carry + $item[$foreignNeedle];
                }, $sum);
            }

            return $sum <= $lte;
        });


        Validator::extend('sum_equal', function ($attribute, $value, $parameters, $validator) {


            $equal = (int) $validator->getData()[$parameters[0]];      # Max value as limit
            $needle = $parameters[1];   # Field name to be sum
            $sum = array_reduce($value, function ($carry, $item) use ($needle) {
                return $carry + $item[$needle];
            }, 0);

            if (isset($parameters[2]) && isset($parameters[3])) {

                 # Aditional foreign data
                $foreignData = (array) $validator->getData()[$parameters[2]];

                # Additional foreign field from data
                $foreignNeedle = $parameters[3];

                $sum = array_reduce($foreignData, function ($carry, $item) use ($foreignNeedle) {
                    return $carry + $item[$foreignNeedle];
                }, $sum);
            }

            return (int) $sum === (int) $equal;
        });
    }
}
