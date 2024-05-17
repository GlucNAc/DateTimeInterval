# GlucNAc/DateTimeInterval

[![Source Code][badge-source]][source]
[![Latest Version][badge-release]][packagist]
[![PHP Version][badge-php]][php]
[![Pipeline status][badge-pipeline]][pipeline]
[![Coverage Status][badge-coverage]][coverage]
[![Total Downloads][badge-downloads]][downloads]

When you want to compute a delay between two DateTimes, it can be quickly tricky to get the result you are expecting for,
and sometimes you need to perform some calculations, which can lead to incorrect result.

DateTimeInterval is wrapper of DateInterval that provides useful methods for calculating delays. Thanks to this library,
there is no need to compute results returned from DateInterval anymore. Moreover, all of its methods are fully tested,
and are explicitly named and commented.

In that way, you don't have to copy/paste the logic you implemented on another project, just install this library and
enjoy.

## Installation

The preferred method of installation is via [Composer][]. Run the following
command to install the package and add it as a requirement to your project's
`composer.json`:

```bash
composer require glucnac/datetimeinterval
```

## Usage

```php
$firstDate = new DateTimeImmutable('2022-07-15');
$secondDate = new DateTimeImmutable('2022-08-15');
$dateTimeInterval = new DateTimeInterval($firstDate, $secondDate);

// Absolute count of days
echo $dateTimeInterval->getDays(); // 31

// Relative count of days
echo $dateTimeInterval->getDays(false); // 0 (15th day of the month (august) - 15th day of the month (july))
```

```php
$firstDate = new DateTimeImmutable('2022-07-15');
$secondDate = new DateTimeImmutable('2023-08-15');
$dateTimeInterval = new DateTimeInterval($firstDate, $secondDate);

// Absolute count of months
echo $dateTimeInterval->getMonths(); // 13

// Relative count of months
echo $dateTimeInterval->getMonths(false); // 1 (8th month of the year (august) - 7th month of the year (july))
```

And so on :
```php
$dateTimeInterval->getYears();
$dateTimeInterval->getHours();
$dateTimeInterval->getMinutes();
$dateTimeInterval->getSeconds();
$dateTimeInterval->getMicroseconds();
```

Result can be signed or unsigned, depending on the third parameter of the constructor (`$returnAbsoluteValue`, default is true).

```php
$firstDate = new DateTimeImmutable('2022-07-15');
$secondDate = new DateTimeImmutable('2022-08-15');
$dateTimeInterval = new DateTimeInterval($firstDate, $secondDate, false);

echo $dateTimeInterval->getDays(); // -31
```

Result can be formatted as a string :

```php
$supDate = new DateTime('2021-08-27 00:00:00');
$infDate = new DateTime('2022-09-29 23:35:59');
$dateTimeInterval = new DateTimeInterval($firstDate, $secondDate);

// Internally uses DateInterval::format() method
echo $dateTimeInterval->format('%y years, %m months, %d days, %h hours, %i minutes, %s seconds'); // 1 years, 1 months, 2 days, 23 hours, 35 minutes, 59 seconds
```

Nostalgic about DateInterval ? No problem, you can get it back :

```php
$dateInterval = $dateTimeInterval->getDateInterval();
```

## What is the purpose ?

To understand the usefulness of this library, let's try to compute some delays.

### Get delays using date_diff()
```php
// Let's say you want to compute some delays between 2022-07-15 and 2022-08-15.

$firstDate = new DateTimeImmutable('2022-07-15');
$secondDate = new DateTimeImmutable('2022-08-15');

$dateInterval = date_diff($secondDate, $firstDate);
// OR
$dateInterval = $firstDate->diff($secondDate);

// You want to count the days between these two dates. Using DateInterval,
// you notice that two properties are available :

// PhpDoc states: "Totals number of days in the interval span"
$dateInterval->days;

// PhpDoc states: "Number of days"
$dateInterval->d;

// Well, the doc of ->d is not really clear, let's see the difference between these two returns

echo $dateInterval->days; // 30
echo $dateInterval->d; // 0

// Nice, it seems ->d is a relative count, whereas ->days give an absolute count

// What about getting the number of months then ?

// PhpDoc states: "Number of months"
echo $dateInterval->m // 1

// We don't yet if it's a relative or an absolute count. So let's change the year to next one :
$firstDate = new DateTimeImmutable('2022-07-15');
$secondDate = new DateTimeImmutable('2023-08-15');
$dateInterval = date_diff($secondDate, $firstDate);

echo $dateInterval->m // 1

// Now it's clear: ->m also returns a relative count
```

Actually: `->y`, `->m`, `->d`, `->h`, `->i`, `->s`, `->f`: all are returning a relative count, which means that for any absolute result,
you must perform some calculations using `->days`, which is the only result to be absolute. Even though these calculations
are simple, rewriting them on each of your project is boring and can lead to inattention mistakes.

That's why this library has been made for: to abstract the calculations and to get a more object-oriented coding.

## Copyright and License

The GlucNAc/DateTimeInterval library is copyright © [GlucNAc](https://gitlab.com/GlucNAc) and licensed for use under the
MIT License (MIT). Please see [LICENSE](https://gitlab.com/GlucNAc/DateTimeInterval/-/blob/master/LICENSE) for more information.


[composer]: http://getcomposer.org/

[badge-source]: http://img.shields.io/badge/source-GlucNAc/DateTimeInterval-blue.svg?style=flat-square
[badge-release]: https://img.shields.io/packagist/v/GlucNAc/DateTimeInterval.svg?style=flat-square&label=release
[badge-license]: https://img.shields.io/packagist/l/GlucNAc/DateTimeInterval.svg?style=flat-square
[badge-php]: https://img.shields.io/packagist/php-v/GlucNAc/DateTimeInterval.svg?style=flat-square
[badge-pipeline]: https://img.shields.io/github/actions/workflow/status/GlucNAc/DateTimeInterval/continuous-integration.yml?branch=master&style=flat-square&logo=github
[badge-coverage]: https://codecov.io/gh/GlucNAc/DateTimeInterval/graph/badge.svg?token=1BJY4T4H9D
[badge-downloads]: https://img.shields.io/packagist/dt/GlucNAc/DateTimeInterval.svg?style=flat-square&colorB=mediumvioletred

[php]: https://php.net
[source]: https://github.com/GlucNAc/DateTimeInterval
[packagist]: https://packagist.org/packages/GlucNAc/DateTimeInterval
[pipeline]: https://github.com/GlucNAc/DateTimeInterval/actions/workflows/continuous-integration.yml
[coverage]: https://codecov.io/gh/GlucNAc/DateTimeInterval
[downloads]: https://packagist.org/packages/GlucNAc/DateTimeInterval
