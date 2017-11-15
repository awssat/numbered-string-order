# numberedStringOrder

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

It can fetch arabic numbers too :
``` php
$numberedStringOrder = new numberedStringOrder();
var_dump($numberedStringOrder->sort(['حلقة 30',
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
        'حلقة الاخيرة',]));
```

#### Get the numbers
``` php
$numberedStringOrder = new numberedStringOrder();
var_dump($numberedStringOrder->getNumbers(['2digits', 'text1', 'three3', 'blank']));
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
