<?php
declare(strict_types=1);
/**
 *-------------------------------------------------------------------------s*
 * 阿里云OSS
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
use Iidestiny\Flysystem\Oss\OssAdapter;

class AliyunOssAdapterFactory implements AdapterFactoryInterface
{
    public function make(array $options)
    {
        return new OssAdapter($options['accessId'], $options['accessSecret'], $options['endpoint'], $options['bucket'], $options['isCName'], $options['prefix']);
    }
}
