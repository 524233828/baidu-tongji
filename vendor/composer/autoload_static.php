<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitc5c18857c43496826f7545d89565d8c8
{
    public static $files = array (
        'd2f0f9bd8db3962884f9f1977a02b6e9' => __DIR__ . '/../..' . '/src/helpers.php',
    );

    public static $prefixLengthsPsr4 = array (
        'J' => 
        array (
            'JoseChan\\BaiduTongji\\' => 21,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'JoseChan\\BaiduTongji\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitc5c18857c43496826f7545d89565d8c8::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitc5c18857c43496826f7545d89565d8c8::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
