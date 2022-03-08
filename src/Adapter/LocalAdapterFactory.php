<?php
declare(strict_types=1);
/**
 *-------------------------------------------------------------------------p*
 * 本地存储
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


namespace Shopwwi\WebmanFilesystem\Adapter;


use Shopwwi\WebmanFilesystem\Contract\AdapterFactoryInterface;
use League\Flysystem\Local\LocalFilesystemAdapter;

class LocalAdapterFactory implements AdapterFactoryInterface
{
    public function make(array $options)
    {
        return new LocalFilesystemAdapter($options['root']);
    }
}