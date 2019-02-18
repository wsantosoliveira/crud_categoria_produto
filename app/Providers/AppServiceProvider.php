<?php

namespace CodeShopping\Providers;

use CodeShopping\Models\ProductInput;
use CodeShopping\Models\ProductOutput;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        ProductInput::created(function ($productInput) {
            $productInput->product->stock += $productInput->amount;
            $productInput->product->save();
        });
        ProductOutput::created(function ($productOutput) {
            $productOutput->product->stock -= $productOutput->amount;
            $productOutput->product->save();
        });
    }

    public function register()
    {
    }
}
