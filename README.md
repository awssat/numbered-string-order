# numberedStringOrder

[![Latest Version on Packagist](https://img.shields.io/packagist/v/awssat/numbered-string-order.svg?style=flat-square)](https://packagist.org/packages/awssat/numbered-string-order)
[![StyleCI](https://styleci.io/repos/110764857/shield?branch=master)](https://styleci.io/repos/110764857)


Sort a string array based on the included numbers naturally.

## Install

Via Composer

``` bash
$ composer require awssat/numbered-string-order
```

## Usage


#### Sort
``` php
$numberedStringOrder = new numberedStringOrder();
var_dump($numberedStringOrder->sort(['2digits', 'text1', 'three3', 'blank']));
```

It can sort Arabic & English numbers too :
``` php
$numberedStringOrder = new numberedStringOrder();
var_dump(

   $numberedStringOrder->sort([
        'episode 5',
        'episode50',
        '499',
        'episode1',
        'episode two hundred',
        'episode one',
        'episode two',
        'episode eleven',
        'episode three'
    ])
    
);


var_dump(

   $numberedStringOrder->sort([
        'حلقة 30',
        'حلقة33',
        'حلقة3٤',
        'حلقة ٥٥ ',
        'حلقه 2 جديدة',
        'حلقه الأولى جديدة',
        'حلقة الثانية جديدة',
        'episode 24',
        '4',
        'حلقة ثلاثة جديدة',
        'حلقة واحد جديدة',
        'حلقتنا اليوم 1',
        'حلقة الاخيرة',
    ])
    
);
```

#### Get the numbers
``` php
$numberedStringOrder = new numberedStringOrder();
var_dump($numberedStringOrder->getNumbers(['2digits', 'text1', 'three3', 'blank']));
```

## Test
```bash
composer test
```


## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
