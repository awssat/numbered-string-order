# numberedStringOrder

[![Latest Version on Packagist](https://img.shields.io/packagist/v/awssat/numbered-string-order.svg?style=flat-square)](https://packagist.org/packages/awssat/numbered-string-order)
[![StyleCI](https://styleci.io/repos/110764857/shield?branch=master)](https://styleci.io/repos/110764857)
[![Build Status](https://img.shields.io/travis/awssat/numberedStringOrder/master.svg?style=flat-square)](https://travis-ci.org/awssat/numberedStringOrder)


Sort an array of strings based on the included numbers naturally. An alternative to PHP built-in natsort function that's actually work.


## Install

Via Composer

``` bash
$ composer require awssat/numbered-string-order
```

## Usage


#### Sort

```php
//if you are using laravel, then instead use:
//$numberedStringOrder = app(Awssat\numberedStringOrder\numberedStringOrder::class);

$numberedStringOrder = new numberedStringOrder();

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
]);
    

>> output: 
[
     "episode1",
     "episode one",
     "episode two",
     "episode three",
     "episode 5",
     "episode eleven",
     "episode50",
     "episode two hundred",
     499,
]
   
```


If you ask why not use the built-in function (natsort), then see the natsort output of the same example above to know why:
```php
 //output of built-in function natsor(): 🤨
 [
     "499",
     "episode1",
     "episode 5",
     "episode50",
     "episode eleven",
     "episode one",
     "episode three",
     "episode two",
     "episode two hundred",
   ]
 ```
 
 
 #### Get the numbers
If you want to use our internal numbers extracting method

```php
$numberedStringOrder->getNumbers(['2digits', 'text1', 'three3', 'two cars', 'blank']);

>> output:
[
     "2digits" => 2,
     "text1" => "1",
     "three3" => "3",
     "two cars" => 2,
     "blank" => "blank",
]
```


#### Convert words to numbers 
This package can also be helpful if you want to convert numerical words to numbers 

```php
new numberedStringOrder();
$numberedStringOrder->englishWordsToNumbers('one hundred twenty-three thousand four hundred fifty-six');
>> output: 123456

//to get arabic words to number use: arabicWordsToNumbers(...)

```



## Test
```bash
composer test
```



Currently, it supports English and Arabic.


## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
