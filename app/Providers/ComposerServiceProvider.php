<?php

namespace DropItems\Providers;

use DropItems\Models\Items\Category;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        \View::composer('layouts.app', function($view){
            // カテゴリーを取得する
            $view->categories = Category::getCategories();
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
