<?php

namespace Marsflow\CachedDataTable;

use Yajra\DataTables\DataTablesServiceProvider;
use Yajra\DataTables\Utilities\Config;
use Yajra\DataTables\Utilities\Request;
use Illuminate\Support\Str;

use Marsflow\CachedDataTable\CachedDataTable;

class CachedDataTableServiceProvider extends DataTablesServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        if ($this->isLumen()) {
            require_once 'lumen.php';
        }

        $this->setupAssets();

        $this->app->alias('datatables', CachedDataTable::class);
        $this->app->singleton('datatables', function () {
            return new CachedDataTable;
        });

        $this->app->singleton('datatables.request', function () {
            return new Request;
        });

        $this->app->singleton('datatables.config', Config::class);
    }

    /**
     * Boot the instance, add macros for datatable engines.
     *
     * @return void
     */
    public function boot()
    {
        $engines = (array) config('datatables.engines');
        foreach ($engines as $engine => $class) {
            $engine = Str::camel($engine);

            if (! method_exists(DataTables::class, $engine) && ! CachedDataTable::hasMacro($engine)) {
                CachedDataTable::macro($engine, function () use ($class) {
                    if (! call_user_func_array([$class, 'canCreate'], func_get_args())) {
                        throw new \InvalidArgumentException();
                    }

                    return call_user_func_array([$class, 'create'], func_get_args());
                });
            }
        }
    }

}