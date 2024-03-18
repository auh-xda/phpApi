<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInita18a51e5e42b41b85a062e99912639cb
{
    public static $files = array (
        '0e489838fcb2b49169e2ddbf26d824e7' => __DIR__ . '/../..' . '/helpers.php',
    );

    public static $prefixLengthsPsr4 = array (
        'p' => 
        array (
            'phpApi\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'phpApi\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInita18a51e5e42b41b85a062e99912639cb::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInita18a51e5e42b41b85a062e99912639cb::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInita18a51e5e42b41b85a062e99912639cb::$classMap;

        }, null, ClassLoader::class);
    }
}
