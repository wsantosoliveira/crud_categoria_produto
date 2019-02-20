<?php

namespace CodeShopping\Providers;

use CodeShopping\Models\Category;
use CodeShopping\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'CodeShopping\Http\Controllers';

    public function boot()
    {
        parent::boot();

        Route::bind("category", function ($value) {
            $query = Category::query();
            $query = $this->onlyTrashedIfRequested($query);
            $collection = $query->whereId($value)->orWhere("slug", $value)->get();
            return $collection->first();
        });
        Route::bind("product", function ($value) {
            $query = Product::query();
            $query = $this->onlyTrashedIfRequested($query);
            $collection = $query->whereId($value)->orWhere("slug", $value)->get();
            return $collection->first();
        });
    }

    private function onlyTrashedIfRequested(Builder $query)
    {
        if (\Request::get("trashed") == 1)
            $query = $query->onlyTrashed();

        return $query;
    }

    public function map()
    {
        $this->mapApiRoutes();
        $this->mapWebRoutes();
    }

    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }

    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }
}
