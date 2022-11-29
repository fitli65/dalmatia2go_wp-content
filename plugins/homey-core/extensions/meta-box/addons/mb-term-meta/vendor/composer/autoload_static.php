<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit81e3f38d05833ccb65d7ec68b48c5b65
{
    public static $prefixLengthsPsr4 = array (
        'M' => 
        array (
            'MBTM\\' => 5,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'MBTM\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'RWMB_Term_Storage' => __DIR__ . '/../..' . '/src/Storage.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit81e3f38d05833ccb65d7ec68b48c5b65::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit81e3f38d05833ccb65d7ec68b48c5b65::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit81e3f38d05833ccb65d7ec68b48c5b65::$classMap;

        }, null, ClassLoader::class);
    }
}
