<?php
/**
 *-------------------------------------------------------------------------p*
 *
 *-------------------------------------------------------------------------h*
 * @copyright  Copyright (c) 2015-2022 Shopwwi Inc. (http://www.shopwwi.com)
 *-------------------------------------------------------------------------c*
 * @license    http://www.shopwwi.com        s h o p w w i . c o m
 *-------------------------------------------------------------------------e*
 * @link       http://www.shopwwi.com by 象讯科技 phcent.com
 *-------------------------------------------------------------------------n*
 * @since      shopwwi象讯·PHP商城系统Pro
 *-------------------------------------------------------------------------t*
 */
namespace Shopwwi\WebmanFilesystem;

use Shopwwi\WebmanFilesystem\Adapter\LocalAdapterFactory;
use Shopwwi\WebmanFilesystem\Contract\AdapterFactoryInterface;
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
    public static function get($adapterName,$config = null): Filesystem
    {
        $options = $config == null ? \config('plugin.shopwwi.filesystem.app', [
            'default' => 'local',
            'storage' => [
                'local' => [
                    'driver' => LocalAdapterFactory::class,
                    'root' => \runtime_path(),
                    'url' => '',
                ],
            ],
        ]) : $config;
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