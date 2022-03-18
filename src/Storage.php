<?php

namespace Shopwwi\WebmanFilesystem;

use support\Request;

class Storage
{
    protected $adapterType = '';
    protected $path = 'storage';
    protected $size = 1024 * 1024 * 10;
    protected $extYes = []; //允许上传文件类型
    protected $extNo = []; // 不允许上传文件类型
    protected $config = [];

    /**
     * @var Closure[]
     */
    protected static $maker = [];

    /**
     * 构造方法
     * @access public
     */
    public function __construct()
    {
        $this->config = config('plugin.shopwwi.filesystem.app');
        $this->adapterType = $this->config['default'] ?? 'local';
        $this->size = $this->config['size'] ?? 1024 * 1024 * 10;
        $this->extYes = $this->config['ext_yes'] ?? [];
        $this->extNo = $this->config['ext_no'] ?? [];
        if (!empty(static::$maker)) {
            foreach (static::$maker as $maker) {
                \call_user_func($maker, $this);
            }
        }
    }

    /**
     * 设置服务注入
     * @access public
     * @param Closure $maker
     * @return void
     */
    public static function maker(Closure $maker)
    {
        static::$maker[] = $maker;
    }

    /**
     * 存储路径
     * @param string $name
     * @return $this
     */
    public function adapter(string $name)
    {
        $this->adapterType = $name;
        return $this;
    }

    /**
     * 存储路径
     * @param string $name
     * @return $this
     */
    public function path(string $name)
    {
        $this->path = $name;
        return $this;
    }

    /**
     * 允许上传文件类型
     * @param array $ext
     * @return $this
     */
    public function extYes(array $ext)
    {
        $this->extYes = $ext;
        return $this;
    }

    /**
     * 不允许上传文件类型
     * @param array $ext
     * @return $this
     */
    public function extNo(array $ext)
    {
        $this->extNo = $ext;
        return $this;
    }

    /**
     * 设置允许文件大小
     * @param int $size
     * @return $this
     */
    public function size(int $size)
    {
        $this->size = $size;
        return $this;
    }

    /**
     * 上传文件
     * @param $file
     * @return void
     */
    public function upload($file)
    {
        if(!in_array($file->getUploadMineType(),$this->extYes)) {
            throw new \Exception('不允许上传文件类型'.$file->getUploadMineType());
        }
        if(in_array($file->getUploadMineType(),$this->extNo)) {
            throw new \Exception('文件类型不被允许'.$file->getUploadMineType());
        }
        if($file->getSize() > $this->size){
            throw new \Exception("上传文件过大（当前大小 {$file->getSize()}，需小于 {$this->size})");
        }
        $filesystem = FilesystemFactory::get($this->adapterType);
        $storageKey = \hash_file('md5', $file->getPathname());
        $fileName = $this->path.'/'.$storageKey.'.'.$file->getUploadExtension();

        $stream = \fopen($file->getRealPath(), 'r+');
        $filesystem->writeStream(
            $fileName,
            $stream
        );
        \fclose($stream);
        $info = [
            'origin_name' => $file->getUploadName(),
            'file_name' => $fileName,
            'storage_key' => $storageKey,
            'file_url' => $this->url($fileName),
            'size' => $file->getSize(),
            'mime_type' => $file->getUploadMineType(),
            'extension' => $file->getUploadExtension(),            
        ];
        if (\substr($file->getUploadMineType(), 0, 5) == 'image') {
            $size = \getimagesize($file);
            $info['file_height'] = $size[1];
            $info['file_width'] = $size[0];
        }
        return \json_decode(\json_encode($info));
    }

    /**
     * 批量上传文件
     * @param $files
     * @return void
     */
    public function uploads($files,$num = 0, $size = 0)
    {
        $result = [];
        if($num > 0 && count($files) > $num){
            throw new \Exception('文件数量超过了'.$num);
        }
        if($size > 0){
            $allSize = 0;
            foreach ($files as $key => $file) {
                $allSize += $file->getSize();
            }
            if($allSize > $size){
                throw new \Exception('文件总大小超过了'.$size);
            }
        }
        foreach ($files as $key => $file) {
            if(!in_array($file->getUploadMineType(),$this->extYes)) {
                throw new \Exception('不允许上传文件类型'.$file->getUploadMineType());
            }
            if(in_array($file->getUploadMineType(),$this->extNo)) {
                throw new \Exception('文件类型不被允许'.$file->getUploadMineType());
            }
            if($file->getSize() > $this->size){
                throw new \Exception("上传文件过大（当前大小 {$file->getSize()}，需小于 {$this->size})");
            }
            $filesystem = FilesystemFactory::get($this->adapterType);
            $storageKey = \hash_file('md5', $file->getPathname());
            $fileName = $this->path.'/'.$storageKey.'.'.$file->getUploadExtension();

            $stream = \fopen($file->getRealPath(), 'r+');
            $filesystem->writeStream(
                $fileName,
                $stream
            );
            \fclose($stream);
            $info = [
                'key' => $key,
                'origin_name' => $file->getUploadName(),
                'file_name' => $fileName,
                'storage_key' => $storageKey,
                'file_url' => $this->url($fileName),
                'size' => $file->getSize(),
                'mime_type' => $file->getUploadMineType(),
                'extension' => $file->getUploadExtension(),
            ];
            if (\substr($file->getUploadMineType(), 0, 5) == 'image') {
                $size = \getimagesize($file);
                $info['file_height'] = $size[1];
                $info['file_width'] = $size[0];
            }
            \array_push($result, $info);
        }
        return \json_decode(\json_encode($result));
    }

    /**
     * 获取url
     * @param string $fileName
     * @return void
     */
    public function url(string $fileName)
    {
        $domain = $this->config['storage'][$this->adapterType]['url'];
        if(empty($this->config['storage'][$this->adapterType]['url'])){
            $domain = '//'.\request()->host();
        }
        return $domain.'/'.$fileName;
    }
    
    /**
     * 动态方法 直接调用is方法进行验证
     * @access public
     * @param string $method 方法名
     * @param array $args   调用参数
     * @return bool
     */
    public function __call(string $method, array $args)
    {
        if ('is' == \strtolower(substr($method, 0, 2))) {
            $method = \substr($method, 2);
        }

        $args[] = \lcfirst($method);

        return \call_user_func_array([$this, 'is'], $args);
    }
}