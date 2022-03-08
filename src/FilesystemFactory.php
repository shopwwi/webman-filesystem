<?php
/**
 *-------------------------------------------------------------------------p*
 *
 *-------------------------------------------------------------------------h*
 * @copyright  Copyright (c) 2015-2021 Phcent Inc. (http://www.phcent.com)
 *-------------------------------------------------------------------------c*
 * @license    http://www.phcent.com        p h c e n t . c o m
 *-------------------------------------------------------------------------e*
 * @link       http://www.phcent.com
 *-------------------------------------------------------------------------n*
 * @since      8988354@qq.com
 *-------------------------------------------------------------------------t*
 */
namespace Phcent\WebmanFilesystem;

use Phcent\WebmanFilesystem\Adapter\LocalAdapterFactory;
use Phcent\WebmanFilesystem\Contract\AdapterFactoryInterface;
use League\Flysystem\Config;
use League\Flysystem\Filesystem;
use Psr\Container\ContainerInterface;
use support\Container;

class FilesystemFactory
{
    /**
     * @var ContainerInterface
     */
    protected static $_instance = null;

    /**
     * @return ContainerInterface
     */
    public static function instance()
    {
        return static::$_instance;
    }
    public static function get($adapterName): Filesystem
    {
        $options = \config('plugin.shopwwi.filesystem.app.filesystem', [
            'default' => 'local',
            'storage' => [
                'local' => [
                    'driver' => LocalAdapterFactory::class,
                    'root' => \runtime_path(),
                ],
            ],
        ]);
        $adapter = static::getAdapter($options, $adapterName);

        return new Filesystem($adapter, $options['storage'][$adapterName] ?? []);
    }

    public static function getAdapter($options, $adapterName)
    {
        if (! $options['storage'] || ! $options['storage'][$adapterName]) {
            throw new \Exception("file configurations are missing {$adapterName} options");
        }
        /** @var AdapterFactoryInterface $driver */
        $driver = Container::get($options['storage'][$adapterName]['driver']);
        return $driver->make($options['storage'][$adapterName]);
    }
    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public static function __callStatic($name, $arguments)
    {
        return static::instance()->{$name}(... $arguments);
    }
}