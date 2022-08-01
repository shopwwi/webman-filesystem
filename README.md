<p align="center">
<a href="https://packagist.org/packages/shopwwi/webman-filesystem"><img src="https://poser.pugx.org/shopwwi/webman-filesystem/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/shopwwi/webman-filesystem"><img src="https://poser.pugx.org/shopwwi/webman-filesystem/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/shopwwi/webman-filesystem"><img src="https://poser.pugx.org/shopwwi/webman-filesystem/license.svg" alt="License"></a>
</p>
# 安装

```
composer require shopwwi/webman-filesystem
```
## 使用方法

- 阿里云 OSS 适配器

```
composer require shopwwi/flysystem-oss
```

- S3 适配器

```
composer require "league/flysystem-aws-s3-v3:^2.0"
```
- 七牛云适配器(php7.X)

```
composer require "overtrue/flysystem-qiniu:^2.0"
```
- 七牛云适配器(php8.X)

```
composer require "overtrue/flysystem-qiniu:^3.0"
```
- 内存适配器

```
composer require "league/flysystem-memory:^2.0"
```
- 腾讯云 COS 适配器(7.x)

```
composer require "overtrue/flysystem-cos:^4.0"
```

- 腾讯云 COS 适配器(8.x)

```
composer require "overtrue/flysystem-cos:^5.0"
```
# 使用
通过FilesystemFactory::get('local') 来调用不同的适配器

```php
    use Shopwwi\WebmanFilesystem\FilesystemFactory;
    public function upload(Request $request)
    {
        $file = $request->file('file');

        $filesystem =  FilesystemFactory::get('local');
        $stream = fopen($file->getRealPath(), 'r+');
        $filesystem->writeStream(
            'uploads/'.$file->getUploadName(),
            $stream
        );
        fclose($stream);
        
        // Write Files
        $filesystem->write('path/to/file.txt', 'contents');

        // Add local file
        $stream = fopen('local/path/to/file.txt', 'r+');
        $result = $filesystem->writeStream('path/to/file.txt', $stream);
        if (is_resource($stream)) {
            fclose($stream);
        }

        // Update Files
        $filesystem->update('path/to/file.txt', 'new contents');

        // Check if a file exists
        $exists = $filesystem->has('path/to/file.txt');

        // Read Files
        $contents = $filesystem->read('path/to/file.txt');

        // Delete Files
        $filesystem->delete('path/to/file.txt');

        // Rename Files
        $filesystem->rename('filename.txt', 'newname.txt');

        // Copy Files
        $filesystem->copy('filename.txt', 'duplicate.txt');

        // list the contents
        $filesystem->listContents('path', false);
    }
```

# 便捷式上传

```php
    use Shopwwi\WebmanFilesystem\Facade\Storage;
    public function upload(\support\Request $request){
         // 适配器 local默认是存储在runtime目录下 public默认是存储在public目录下
         // 可访问的静态文件建议public
         // 默认适配器是local
         Storage::adapter('public');
        //单文件上传
        $file = $request->file('file');
        $result = Storage::upload($file);
        //单文件判断
        try {
            $result = Storage::adapter('public')->path('storage/upload/user')->size(1024*1024*5)->extYes(['image/jpeg','image/gif'])->extNo(['image/png'])->upload($file);
         }catch (\Exception $e){
            $e->getMessage();
         }
         
         //多文件上传
         $files = $request->file();
         $result = Storage::uploads($files);
         try {
         //uploads 第二个参数为限制文件数量 比如设置为10 则只允许上传10个文件 第三个参数为允许上传总大小 则本列表中文件总大小不得超过设定
            $result = Storage::adapter('public')->path('storage/upload/user')->size(1024*1024*5)->extYes(['image/jpeg','image/gif'])->extNo(['image/png'])->uploads($files,10,1024*1024*100);
         }catch (\Exception $e){
            $e->getMessage();
         }
         
         //获取文件外网
         $filesName = 'storage/a4bab140776e0c1d57cc316266e1ca05.png';
         $fileUrl = Storage::url($filesName);
         //指定选定器外网
         $fileUrl = Storage::adapter('oss')->url($filesName);
    }
    
```

###静态方法（可单独设定）

| 方法      | 描述            | 默认                 |
|---------|---------------|--------------------|
| adapter | 选定器           | config中配置的default  | 
| size    | 单文件大小         | config中配置的max_size |
| extYes  | 允许上传文件类型      | config中配置的ext_yes  |
| extNo   | 不允许上传文件类型     | config中配置的ext_no   |
| path    | 文件存放路径(非完整路径) | storage            |

### 响应字段

| 字段          | 	描述           | 	示例值                                                          |
|-------------|---------------|---------------------------------------------------------------|
| origin_name | 源文件名称         | webman.png                                                    |
| file_name   | 文件路径及名称       | storage/a4bab140776e0c1d57cc316266e1ca05.png                  |
| storage_key | 文件随机key       | a4bab140776e0c1d57cc316266e1ca05                              |
| file_url    | 文件访问外网        | //127.0.0.1:8787/storage/cab473e23b638c2ad2ad58115e28251c.png |
| size        | 文件大小          | 22175                                                         |
| mime_type   | 文件类型          | image/jpeg                                                    |
| extension   | 文件尾缀          | jpg                                                           |
| width       | 图片宽度（图片类型才返回） | 206                                                           |
| height      | 图片高度（图片类型才返回）        | 206                                                           |
