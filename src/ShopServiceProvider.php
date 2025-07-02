<?php

namespace Branzia\Shop;
use Illuminate\Support\Facades\File;
use Branzia\Blueprint\BranziaServiceProvider;

class ShopServiceProvider extends BranziaServiceProvider
{
     public function moduleName(): string
    {
        return 'Shop';
    }
    public function moduleRootPath():string{
        return dirname(__DIR__);
    }

    public function boot(): void
    {
        parent::boot();
    }

    public function register(): void
    {
        parent::register();
    }

}

