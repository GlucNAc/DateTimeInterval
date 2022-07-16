# GlucNAc/DateTimeInterval

[![Source Code][badge-source]][source]
[![Latest Version][badge-release]][packagist]
[![PHP Version][badge-php]][php]
[![Pipeline status][badge-pipeline]][pipeline]
[![Coverage Status][badge-coverage]][coverage]
[![Total Downloads][badge-downloads]][downloads]

When you want to compute delay between two DateTimes, it can be quickly tricky to get the result you are expecting for,
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

## What is the purpose ?

To understand the usefulness of this library, let's try to compute some delays.

### Get delay using date_diff()
```php
// Let's say you want to compute some delays between 2022-07-15 and 2022-08-15.

$firstDate = new DateTimeImmutable('2022-07-15');
$secondDate = new DateTimeImmutable('2022-08-15');

$dateInterval = date_diff($secondDate, $firstDate);
// OR
$dateInterval = $firstDate->diff($secondDate);

// You want to count the days between these two dates. Using DateInterval,
// you notice that two properties are available :

// PhpDoc : Totals number of days in the interval span.
$dateInterval->days;

// PhpDoc : Number of days.
$dateInterval->d;

// Well, the doc of ->d is not really clear, let's see the difference between these two returns

$dateInterval->days; // 30
$dateInterval->d; // 0

// Nice, it seems ->d is a relative count, whereas ->days give an absolute count

// What about getting the number of months then ?

// PhpDoc : number of months
$dateInterval->m // 1

// Seems to be ok. What about changing the year to next one :
$firstDate = new DateTimeImmutable('2022-07-15');
$secondDate = new DateTimeImmutable('2023-08-15');
$dateInterval = date_diff($secondDate, $firstDate);

$dateInterval->m // 1

// ->m also returns a relative count
```

->y, ->m, ->d, ->h, ->i, ->s, ->f : all are returning a relative count, which means that for any absolute result,
you must perform some calculations using ->days, which is the only result to be absolute. Even though these calculations
are simple, rewriting them on each of your project is boring and can lead to inattention mistakes.

That's why this library has been made for : to abstract the calculations and to get a more object-oriented coding.

### Get delay using DateTimeInterval
```php
$firstDate = new DateTimeImmutable('2022-07-15');
$secondDate = new DateTimeImmutable('2022-08-15');
$dateTimeInterval = new DateTimeInterval($firstDate, $secondDate);

// Absolute count of days
$dateTimeInterval->getDays();

// Relative count of days
$dateTimeInterval->getDays(false);

// Absolute count of months
$dateTimeInterval->getMonths();

// Relative count of months
$dateTimeInterval->getMonths(false);

// And so on...

// Nostalgic about DateInterval ?
$dateInterval = $dateTimeInterval->getDateInterval();
```

## Copyright and License

The GlucNAc/DateTimeInterval library is copyright © [GlucNAc](https://gitlab.com/GlucNAc)
and licensed for use under the MIT License (MIT). Please see [LICENSE][] for
more information.


[composer]: http://getcomposer.org/

[badge-source]: http://img.shields.io/badge/source-GlucNAc/DateTimeInterval-blue.svg?style=flat-square
[badge-release]: https://img.shields.io/packagist/v/GlucNAc/DateTimeInterval.svg?style=flat-square&label=release
[badge-license]: https://img.shields.io/packagist/l/GlucNAc/DateTimeInterval.svg?style=flat-square
[badge-php]: https://img.shields.io/packagist/php-v/GlucNAc/DateTimeInterval.svg?style=flat-square
[badge-pipeline]: https://gitlab.com/GlucNAc/DateTimeInterval/badges/master/pipeline.svg
[badge-coverage]: https://gitlab.com/GlucNAc/DateTimeInterval/badges/master/coverage.svg
[badge-downloads]: https://img.shields.io/packagist/dt/GlucNAc/DateTimeInterval.svg?style=flat-square&colorB=mediumvioletred

[php]: https://php.net
[source]: https://gitlab.com/datetimetools/datetimeinterval
[packagist]: https://packagist.org/packages/GlucNAc/DateTimeInterval
[pipeline]: https://gitlab.com/GlucNAc/DateTimeInterval/-/commits/master
[coverage]: https://gitlab.com/GlucNAc/DateTimeInterval/-/commits/master
[downloads]: https://packagist.org/packages/GlucNAc/DateTimeInterval
