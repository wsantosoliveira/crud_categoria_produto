<?php

namespace CodeShopping\Providers;

use CodeShopping\Common\OnlyTrashed;
use CodeShopping\Models\Category;
use CodeShopping\Models\Product;
use CodeShopping\User;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    use OnlyTrashed;

    protected $namespace = 'CodeShopping\Http\Controllers';

    public function boot()
    {
        parent::boot();

        Route::bind("category", function ($value) {
            $request = app(Request::class);
            $query = Category::query();
            $query = $this->onlyTrashedIfRequested($request, $query);
            $collection = $query->whereId($value)->orWhere("slug", $value)->get();
            return $collection->first();
        });
        Route::bind("product", function ($value) {
            $request = app(Request::class);
            $query = Product::query();
            $query = $this->onlyTrashedIfRequested($request, $query);
            $collection = $query->whereId($value)->orWhere("slug", $value)->get();
            return $collection->first();
        });
        Route::bind("user", function ($value) {
            $request = app(Request::class);
            $query = User::query();
            $query = $this->onlyTrashedIfRequested($request, $query);
            return $query->find($value);
        });
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
