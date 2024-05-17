<?php

declare(strict_types=1);

namespace GlucNAc\DateTimeInterval\Test;

use DateTime;
use GlucNAc\DateTimeInterval\DateTimeInterval;
use PHPUnit\Framework\TestCase;

class DateTimeIntervalTest extends TestCase
{
    /*
     * IS NEGATIVE
     */

    /**
     * @covers \GlucNAc\DateTimeInterval\DateTimeInterval::isNegative()
     */
    public function testIsNegativeOk(): void
    {
        $supDate = new DateTime('2022-08-29');
        $infDate = new DateTime('2021-08-28');

        $dateTimeInterval = new DateTimeInterval($infDate, $supDate, false);

        self::assertTrue($dateTimeInterval->isNegative());
    }

    public function testIsNegativeKo(): void
    {
        $supDate = new DateTime('2022-08-29');
        $infDate = new DateTime('2021-08-28');

        $dateTimeInterval = new DateTimeInterval($supDate, $infDate, false);

        self::assertFalse($dateTimeInterval->isNegative());
    }

    public function testIsNegativeForceKo(): void
    {
        $supDate = new DateTime('2022-08-29');
        $infDate = new DateTime('2021-08-28');

        $dateTimeInterval = new DateTimeInterval($infDate, $supDate, true);

        self::assertFalse($dateTimeInterval->isNegative());
    }

    /*
     * YEARS
     */

    public function testGetYearsPositive(): void
    {
        $supDate = new DateTime('2022-08-29');
        $infDate = new DateTime('2021-08-28');

        $dateTimeInterval = new DateTimeInterval($supDate, $infDate);

        self::assertEquals(1, $dateTimeInterval->getYears());
    }

    public function testGetYearsNegative(): void
    {
        $supDate = new DateTime('2022-08-29');
        $infDate = new DateTime('2021-08-28');

        $dateTimeInterval = new DateTimeInterval($infDate, $supDate);

        self::assertEquals(-1, $dateTimeInterval->getYears());
    }

    /*
     * MONTHS
     */

    public function testGetMonthsAbsolutePositive(): void
    {
        $supDate = new DateTime('2022-09-28');
        $infDate = new DateTime('2021-06-28');

        $dateTimeInterval = new DateTimeInterval($supDate, $infDate);

        self::assertEquals(15, $dateTimeInterval->getMonths());
    }

    public function testGetMonthsRelativePositive(): void
    {
        $supDate = new DateTime('2022-09-28');
        $infDate = new DateTime('2021-06-28');

        $dateTimeInterval = new DateTimeInterval($supDate, $infDate);

        self::assertEquals(3, $dateTimeInterval->getMonths(false));
    }

    public function testGetMonthsAbsoluteNegative(): void
    {
        $supDate = new DateTime('2022-09-28');
        $infDate = new DateTime('2021-06-28');

        $dateTimeInterval = new DateTimeInterval($infDate, $supDate);

        self::assertEquals(-15, $dateTimeInterval->getMonths());
    }

    public function testGetMonthsRelativeNegative(): void
    {
        $supDate = new DateTime('2022-09-28');
        $infDate = new DateTime('2021-06-28');

        $dateTimeInterval = new DateTimeInterval($infDate, $supDate);

        self::assertEquals(-3, $dateTimeInterval->getMonths(false));
    }

    /*
     * DAYS
     */

    public function testGetDaysAbsolutePositive(): void
    {
        $supDate = new DateTime('2021-08-28');
        $infDate = new DateTime('2021-06-29');

        $dateTimeInterval = new DateTimeInterval($supDate, $infDate);

        self::assertEquals(60, $dateTimeInterval->getDays());
    }

    public function testGetDaysRelativePositive(): void
    {
        $supDate = new DateTime('2021-08-28');
        $infDate = new DateTime('2021-06-29');

        $dateTimeInterval = new DateTimeInterval($supDate, $infDate);

        self::assertEquals(30, $dateTimeInterval->getDays(false));
    }

    public function testGetDaysAbsoluteNegative(): void
    {
        $supDate = new DateTime('2021-08-28');
        $infDate = new DateTime('2021-06-27');

        $dateTimeInterval = new DateTimeInterval($infDate, $supDate);

        self::assertEquals(-62, $dateTimeInterval->getDays());
    }

    public function testGetDaysRelativeNegative(): void
    {
        $supDate = new DateTime('2021-08-28');
        $infDate = new DateTime('2021-06-27');

        $dateTimeInterval = new DateTimeInterval($infDate, $supDate);

        self::assertEquals(-1, $dateTimeInterval->getDays(false));
    }

    /*
     * HOURS
     */

    public function testGetHoursAbsolutePositive(): void
    {
        $supDate = new DateTime('2021-08-28 00:00:00');
        $infDate = new DateTime('2021-08-27 00:00:00');

        $dateTimeInterval = new DateTimeInterval($supDate, $infDate);

        self::assertEquals(24, $dateTimeInterval->getHours());
    }

    public function testGetHoursRelativePositive(): void
    {
        $supDate = new DateTime('2021-08-28 00:00:00');
        $infDate = new DateTime('2021-08-27 00:00:00');

        $dateTimeInterval = new DateTimeInterval($supDate, $infDate);

        self::assertEquals(0, $dateTimeInterval->getHours(false));
    }

    public function testGetHoursAbsoluteNegative(): void
    {
        $infDate = new DateTime('2021-08-27 00:00:00');
        $supDate = new DateTime('2021-08-28 00:00:00');

        $dateTimeInterval = new DateTimeInterval($infDate, $supDate);

        self::assertEquals(-24, $dateTimeInterval->getHours());
    }

    public function testGetHoursRelativeNegative(): void
    {
        $infDate = new DateTime('2021-08-27 00:00:00');
        $supDate = new DateTime('2021-08-28 00:00:00');

        $dateTimeInterval = new DateTimeInterval($infDate, $supDate);

        self::assertEquals(0, $dateTimeInterval->getHours(false));
    }

    /*
     * MINUTES
     */

    public function testGetMinutesAbsolutePositive(): void
    {
        $supDate = new DateTime('2021-08-28 00:01:00');
        $infDate = new DateTime('2021-08-27 00:00:00');

        $dateTimeInterval = new DateTimeInterval($supDate, $infDate);

        self::assertEquals(1441, $dateTimeInterval->getMinutes());
    }

    public function testGetMinutesRelativePositive(): void
    {
        $supDate = new DateTime('2021-08-28 00:01:00');
        $infDate = new DateTime('2021-08-27 00:00:00');

        $dateTimeInterval = new DateTimeInterval($supDate, $infDate);

        self::assertEquals(1, $dateTimeInterval->getMinutes(false));
    }

    public function testGetMinutesAbsoluteNegative(): void
    {
        $infDate = new DateTime('2021-08-27 00:00:00');
        $supDate = new DateTime('2021-08-28 00:01:00');

        $dateTimeInterval = new DateTimeInterval($infDate, $supDate);

        self::assertEquals(-1441, $dateTimeInterval->getMinutes());
    }

    public function testGetMinutesRelativeNegative(): void
    {
        $infDate = new DateTime('2021-08-27 00:00:00');
        $supDate = new DateTime('2021-08-28 00:01:00');

        $dateTimeInterval = new DateTimeInterval($infDate, $supDate);

        self::assertEquals(-1, $dateTimeInterval->getMinutes(false));
    }

    /*
     * SECONDS
     */

    public function testGetSecondsAbsolutePositive(): void
    {
        $supDate = new DateTime('2021-08-28 00:01:00');
        $infDate = new DateTime('2021-08-27 23:59:00');

        $dateTimeInterval = new DateTimeInterval($supDate, $infDate);

        self::assertEquals(120, $dateTimeInterval->getSeconds());
    }

    public function testGetSecondsRelativePositive(): void
    {
        $supDate = new DateTime('2021-08-28 00:01:00');
        $infDate = new DateTime('2021-08-27 00:00:00');

        $dateTimeInterval = new DateTimeInterval($supDate, $infDate);

        self::assertEquals(0, $dateTimeInterval->getSeconds(false));
    }

    public function testGetSecondsAbsoluteNegative(): void
    {
        $infDate = new DateTime('2021-08-27 23:59:00');
        $supDate = new DateTime('2021-08-28 00:01:00');

        $dateTimeInterval = new DateTimeInterval($infDate, $supDate);

        self::assertEquals(-120, $dateTimeInterval->getSeconds());
    }

    public function testGetSecondsRelativeNegative(): void
    {
        $infDate = new DateTime('2021-08-27 23:59:00');
        $supDate = new DateTime('2021-08-28 00:01:00');

        $dateTimeInterval = new DateTimeInterval($infDate, $supDate);

        self::assertEquals(0, $dateTimeInterval->getSeconds(false));
    }

    /*
     * MICROSECONDS
     */

    public function testGetMicroSecondsAbsolutePositive(): void
    {
        $supDate = new DateTime('2021-08-28 00:00:01.100');
        $infDate = new DateTime('2021-08-27 23:59:59.100');

        $dateTimeInterval = new DateTimeInterval($supDate, $infDate);

        self::assertEquals(2000.0, $dateTimeInterval->getMicroSeconds());
    }

    public function testGetMicroSecondsRelativePositive(): void
    {
        $supDate = new DateTime('2021-08-28 00:00:01.100');
        $infDate = new DateTime('2021-08-27 23:59:59.100');

        $dateTimeInterval = new DateTimeInterval($supDate, $infDate);

        self::assertEquals(0.0, $dateTimeInterval->getMicroSeconds(false));
    }

    public function testGetMicroSecondsAbsoluteNegative(): void
    {
        $infDate = new DateTime('2021-08-27 23:59:59.100');
        $supDate = new DateTime('2021-08-28 00:00:01.100');

        $dateTimeInterval = new DateTimeInterval($infDate, $supDate);

        self::assertEquals(-2000.0, $dateTimeInterval->getMicroSeconds());
    }

    public function testGetMicroSecondsRelativeNegative(): void
    {
        $infDate = new DateTime('2021-08-27 23:59:59.100');
        $supDate = new DateTime('2021-08-28 00:00:01.100');

        $dateTimeInterval = new DateTimeInterval($infDate, $supDate);

        self::assertEquals(-0.0, $dateTimeInterval->getMicroSeconds(false));
    }
}
