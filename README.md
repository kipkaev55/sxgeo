# SypexGeo Reader #

## Description ##

This package provides information about the user's GEO, works with free [Sypex Geo2](https://sypexgeo.net/).

## Install via Composer ##

We recommend installing this package with [Composer](http://getcomposer.org/).

### Download Composer ###

To download Composer, run in the root directory of your project:

```bash
curl -sS https://getcomposer.org/installer | php
```

You should now have the file `composer.phar` in your project directory.

### Install Dependencies ###

Run in your project root:

```
php composer.phar require kipkaev55/sxgeo:1.0.1
```

You should now have the files `composer.json` and `composer.lock` as well as
the directory `vendor` in your project directory. If you use a version control
system, `composer.json` should be added to it.

### Require Autoloader ###

After installing the dependencies, you need to require the Composer autoloader
from your code:

```php
require 'vendor/autoload.php';
```

## Usage ##

Straightforward:

```php
require_once __DIR__ . '/vendor/autoload.php'; // Autoload files using Composer autoload

use SypexGeo\Reader;

$reader = new Reader('SxGeoCity.dat', 'ru');
var_export($reader->getGeo('127.0.0.1'));
var_export($reader->getGeo('192.168.0.1'));
var_export($reader->getGeo('217.25.213.220'));
```

## Copyright and License ##

* This software is Copyright (c) 2017 by [Pro.Motion](http://prmotion.ru).
* This is free software, licensed under the MIT license
* SypexGeo licensed under the BSD.
