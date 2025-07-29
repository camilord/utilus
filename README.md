# camilord/utilus
Camilo3rd's PHP Utils Library

[![codecov](https://codecov.io/gh/camilord/utilus/branch/master/graph/badge.svg)](https://codecov.io/gh/camilord/utilus)


# Installing the library
```json
{
    "require": {
        "camilord/utilus": "^1.0"
    }
}
```

or 

```bash
composer require camilord/utilus
```

# Usage

This library is my collection from my various projects. 
It is a mini library which every time I create a project, 
I don't have to recreate these classes and functions, 
all I need to do is add this package and start my work.
Few example below:

GENERATING UUID
```php
// I need UUID
echo UUID::v4();
```
OUTPUT:
 
``b9ef0e9e-3249-31a1-a529-640a129890ac``

UPLOADING FILE
```php
// I need to process upload file
$tmp_dir = '/tmp/junkies/';
$uploader = new FileUpload($_FILES);
$uploader->setTemporaryUploadDir($tmp_dir, true);
$fileObj = $uploader->processUpload('document_name');
echo $fileObj->getFilePath();
```
OUTPUT: 

``/tmp/junkies/tmp_073240_03927845092742.jpg``

GET DOMAIN SSL EXPIRY DAYS LEFT
```php
// I need to know the number of days left for my domain SSL
$sslUtil = new SSLUtil();
$url = 'https://www.abcs.co.nz';
$days = $sslUtil->getSslDaysLeft($url);
if ($days === false) {
    echo "Error! Cannot fetch SSL information.";
} else {
    echo $days.' days left';
}
```
OUTPUT: 

``370 days left``


AWS SQS CHUNKING DATA


Symfony:
```php
$chunks = ArrayUtilus::aws_sqs_array_chunk($data);

foreach ($chunks as $chunk) 
{
    $this->bus->dispatch(new DataUpdateMessage($chunk));
}
```

Laravel:
```php
$chunks = ArrayUtilus::aws_sqs_array_chunk($data);

foreach ($chunks as $chunk) 
{
    DataUpdateQueue::dispatch($chunk)->onConnection($sqs_connection);
}
```
