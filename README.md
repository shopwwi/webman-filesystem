# 安装

```
composer require shopwwi/webman-filesystem
```
## 使用方法
```


- 阿里云 OSS 适配器

```
composer require shopwwi/flysystem-oss
```
- S3 适配器

```
composer require "league/flysystem-aws-s3-v3:^2.0"
```
- 七牛云适配器

```
composer require "overtrue/flysystem-qiniu:^2.0"
```
- 内存适配器

```
composer require "league/flysystem-memory:^2.0"
```
- 腾讯云 COS 适配器


```
composer require "overtrue/flysystem-cos:^4.0"
```
# 使用
通过FilesystemFactory::get('local') 来调用不同的适配器

```
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

