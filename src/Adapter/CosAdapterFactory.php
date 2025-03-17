<?php
declare(strict_types=1);
/**
 *-------------------------------------------------------------------------s*
 * 腾讯云COS
 *-------------------------------------------------------------------------h*
 * @copyright  Copyright (c) 20 Shopwwi Inc. (http://www.shopwwi.com)
 *-------------------------------------------------------------------------o*
 * @license    http://www.shopwwi.com        s h o p w w i . c o m
 *-------------------------------------------------------------------------p*
 * @link       http://www.shopwwi.com by
 *-------------------------------------------------------------------------w*
 * @since      shopwwi
 *-------------------------------------------------------------------------w*
 */


namespace Shopwwi\WebmanFilesystem\Adapter;


use Shopwwi\WebmanFilesystem\Contract\AdapterFactoryInterface;
use Overtrue\Flysystem\Cos\CosAdapter;

class CosAdapterFactory implements AdapterFactoryInterface
{
    public function make(array $options)
    {
        return new CosAdapter($options);
    }
}