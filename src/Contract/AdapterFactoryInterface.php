<?php
/**
 *-------------------------------------------------------------------------s*
 * 
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

namespace Shopwwi\WebmanFilesystem\Contract;

use League\Flysystem\AdapterInterface;
use League\Flysystem\FilesystemAdapter;
interface AdapterFactoryInterface
{
    /**
     * @param array $options
     * @return mixed
     */
    public function make(array $options);
}