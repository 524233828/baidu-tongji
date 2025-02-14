<?php
/**
 * Created by PhpStorm.
 * User: mushan
 * Date: 2016/11/23
 * Time: 16:57
 */
namespace JoseChan\BaiduTongji;

use Illuminate\Support\ServiceProvider;

class BaiduTongjiServiceProvider extends ServiceProvider
{
//    protected $defer = true;

    public function boot()
    {
        $config_path = __DIR__ . '/config.php';
        $this->publishes([
            $config_path => config_path('baidu_tongji.php'),
        ]);
        $this->mergeConfigFrom(
            $config_path, 'baidu_tongji'
        );
    }

    public function register()
    {
        $this->app->singleton('BaiduTongji', function ($app) {
            return new BaiduTongji(config('baidu_tongji'));
        });
    }
}