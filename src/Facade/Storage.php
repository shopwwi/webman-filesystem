<?php
declare (strict_types = 1);
namespace Shopwwi\WebmanFilesystem\Facade;
/**
 * @see \Shopwwi\WebmanFilesystem\Storage
 * @mixin \Shopwwi\WebmanFilesystem\Storage
 * @method adapter(string $name) static 设置选定器
 * @method path(string $path) static 上传文件存储路径
 * @method size(string $size) static 允许单文件大小
 * @method extYes(array $ext) static 允许上传文件类型
 * @method extNo(array $ext) static 不允许上传文件类型
 * @method url(string $fileName) static 获取文件访问地址 
 * @method upload(string $file) static 上传文件
 * @method uploads(string $files,$num = 0, $size = 0) static 批量上传文件
 * @method base64Upload($baseImg)  static base64文件上传
 * @method processUpload($file,$processFunction = null,$same = true) static 处理图片上传
 */
class Storage
{
    protected static $_instance = null;


    public static function instance()
    {
        if (!static::$_instance) {
            static::$_instance = new \Shopwwi\WebmanFilesystem\Storage();
        }
        return static::$_instance;
    }
    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public static function __callStatic($name, $arguments)
    {
        return static::instance()->{$name}(... $arguments);
    }
}