<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit3aaff7c34e8808af15b749584a418fda
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Paylike\\Tests\\' => 14,
            'Paylike\\' => 8,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Paylike\\Tests\\' => 
        array (
            0 => __DIR__ . '/..' . '/paylike/php-api/tests',
        ),
        'Paylike\\' => 
        array (
            0 => __DIR__ . '/..' . '/paylike/php-api/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit3aaff7c34e8808af15b749584a418fda::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit3aaff7c34e8808af15b749584a418fda::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit3aaff7c34e8808af15b749584a418fda::$classMap;

        }, null, ClassLoader::class);
    }
}
