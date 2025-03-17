<?php
declare(strict_types=1);
/**
 *-------------------------------------------------------------------------s*
 * S3
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

use Aws\Handler\GuzzleV6\GuzzleHandler;
use Aws\S3\S3Client;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use League\Flysystem\AwsS3V3\AwsS3V3Adapter;
use Shopwwi\WebmanFilesystem\Contract\AdapterFactoryInterface;

class S3AdapterFactory implements AdapterFactoryInterface
{
    public function make(array $options)
    {
        $handler = new GuzzleHandler();
        $options = array_merge($options, ['http_handler' => $handler]);
        $client = new S3Client($options);
        return new AwsS3V3Adapter($client, $options['bucket_name'], '');
    }
}