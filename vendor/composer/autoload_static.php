<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit6c3d20f0c6ebd8103d2707b608d29819
{
    public static $prefixLengthsPsr4 = array (
        'F' => 
        array (
            'Firebase\\JWT\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Firebase\\JWT\\' => 
        array (
            0 => __DIR__ . '/..' . '/firebase/php-jwt/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit6c3d20f0c6ebd8103d2707b608d29819::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit6c3d20f0c6ebd8103d2707b608d29819::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
