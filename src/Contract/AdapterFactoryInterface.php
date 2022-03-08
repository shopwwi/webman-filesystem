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

namespace Phcent\WebmanFilesystem\Contract;

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