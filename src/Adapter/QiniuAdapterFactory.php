<?php
declare(strict_types=1);
/**
 *-------------------------------------------------------------------------s*
 * 七牛云
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

use Overtrue\Flysystem\Qiniu\QiniuAdapter;
use Shopwwi\WebmanFilesystem\Contract\AdapterFactoryInterface;

class QiniuAdapterFactory implements AdapterFactoryInterface
{
    public function make(array $options)
    {
        return new QiniuAdapter($options['accessKey'], $options['secretKey'], $options['bucket'], $options['domain']);
    }
}