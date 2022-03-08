<?php
declare(strict_types=1);
/**
 *-------------------------------------------------------------------------p*
 * FTP
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