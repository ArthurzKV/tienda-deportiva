<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitf2253f8efe5da21a35ca9c8a54852440
{
    public static $prefixLengthsPsr4 = array (
        'R' => 
        array (
            'Rios\\Parcial3web\\' => 17,
        ),
        'F' => 
        array (
            'Firebase\\JWT\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Rios\\Parcial3web\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
        'Firebase\\JWT\\' => 
        array (
            0 => __DIR__ . '/..' . '/firebase/php-jwt/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitf2253f8efe5da21a35ca9c8a54852440::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitf2253f8efe5da21a35ca9c8a54852440::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitf2253f8efe5da21a35ca9c8a54852440::$classMap;

        }, null, ClassLoader::class);
    }
}