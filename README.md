# camilord/utilus
Camilo3rd's PHP Utils Library

[![codecov](https://codecov.io/gh/camilord/utilus/branch/master/graph/badge.svg)](https://codecov.io/gh/camilord/utilus)


# Installing the library
```
{
    "require": {
        "camilord/utilus": "^1.0"
    }
}
```

or 

```
composer require camilord/utilus
```

# Usage

This library is my collection from my various projects. 
It is a mini library which every time I create a project, 
I don't have to recreate these classes and functions, 
all I need to do is add this package and start my work.
Few example below:

```$php
// I need UUID
$uuid = UUID::v4();
```
OUTPUT: b9ef0e9e-3249-31a1-a529-640a129890ac
```$php
// I need to process upload file
$tmp_dir = '/tmp/junkies/';
$uploader = new FileUpload($_FILES);
$uploader->setTemporaryUploadDir($tmp_dir, true);
$fileObj = $uploader->processUpload('document_name');
echo $fileObj->getFilePath();
```
OUTPUT: /tmp/junkies/tmp_073240_03927845092742.jpg
```$php
// I need to use leading zeroes so the display is awesome
$val = '1208';
$new_val = NumericUtilus::leading_zeroes($val, 6);
```
OUTPUT: 001208
