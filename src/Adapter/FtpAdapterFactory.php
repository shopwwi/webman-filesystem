<?php
declare(strict_types=1);
/**
 *-------------------------------------------------------------------------s*
 * FTP
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

use League\Flysystem\Adapter\Ftp;
use League\Flysystem\Ftp\ConnectivityCheckerThatCanFail;
use League\Flysystem\Ftp\FtpAdapter;
use League\Flysystem\Ftp\FtpConnectionOptions;
use League\Flysystem\Ftp\NoopCommandConnectivityChecker;
use Shopwwi\WebmanFilesystem\Contract\AdapterFactoryInterface;

class FtpAdapterFactory implements AdapterFactoryInterface
{
    public function make(array $options)
    {
            $options = FtpConnectionOptions::fromArray($options);
            $connectivityChecker = new ConnectivityCheckerThatCanFail(new NoopCommandConnectivityChecker());
            return new FtpAdapter($options, null, $connectivityChecker);
    }
}