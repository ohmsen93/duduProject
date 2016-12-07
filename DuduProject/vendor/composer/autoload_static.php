<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitc68c2060284f5b4d59ba3fae7ae1b2e3
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Symfony\\Component\\Filesystem\\' => 29,
            'Symfony\\Component\\Config\\' => 25,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Symfony\\Component\\Filesystem\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/filesystem',
        ),
        'Symfony\\Component\\Config\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/config',
        ),
    );

    public static $prefixesPsr0 = array (
        'T' => 
        array (
            'Twig_' => 
            array (
                0 => __DIR__ . '/..' . '/twig/twig/lib',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitc68c2060284f5b4d59ba3fae7ae1b2e3::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitc68c2060284f5b4d59ba3fae7ae1b2e3::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInitc68c2060284f5b4d59ba3fae7ae1b2e3::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}
