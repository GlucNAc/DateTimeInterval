<?php

namespace GlucNAc\DateTimeInterval;

use DateInterval;
use RuntimeException;

/**
 * Class DateTimeInterval
 *
 * * <em>$supDate</em> should be greater than <em>$infDate</em>.
 *
 * * Returns negative value if <em>$supDate</em> < <em>$infDate</em>,
 * unless <em>$forceReturningPositiveValue</em> = true.
 */
class DateTimeInterval
{
    private DateInterval $dateInterval;

    public function __construct(
        \DateTimeInterface $supDate,
        \DateTimeInterface $infDate,
        bool $returnAbsoluteValue = false
    ) {
        $this->dateInterval = \date_diff($infDate, $supDate, $returnAbsoluteValue);
    }

    /**
     * Returns the count of COMPLETED days between the two DateTime instances of this interval.
     *
     * <u>POSITIVE VALUES</u>
     *
     * e.g. For 2022-08-29 and 2021-08-28: returns 1
     *
     * e.g. For 2022-08-28 and 2021-08-28: returns 1
     *
     * e.g. For 2022-08-27 and 2021-08-28: returns 0
     *
     * <u>NEGATIVE VALUES</u>
     *
     * e.g. For 2021-08-28 and 2022-08-29: returns -1
     *
     * e.g. For 2021-08-28 and 2022-08-28: returns -1
     *
     * e.g. For 2021-08-28 and 2022-08-27: returns 0
     *
     * @see date_diff()
     */
    public function getYears(): int
    {
        $count = $this->dateInterval->y;

        return $this->isNegative() ? - $count : $count;
    }

    /**
     * Returns the count of COMPLETED months between the two DateTime instances of this interval.
     *
     * <u>POSITIVE VALUES</u>
     *
     * e.g. For 2022-09-28 and 2021-06-28:
     * * with <em>$absoluteCount</em> = true, this method will return 15
     * * with <em>$absoluteCount</em> = false, this method will return 3
     *
     * e.g. For 2022-09-28 and 2021-06-29:
     * * with <em>$absoluteCount</em> = true, this method will return 14
     * * with <em>$absoluteCount</em> = false, this method will return 2
     *
     * <u>NEGATIVE VALUES</u>
     *
     * e.g. For 2022-06-28 and 2021-09-28:
     * * with <em>$absoluteCount</em> = true, this method will return -15
     * * with <em>$absoluteCount</em> = false, this method will return -3
     *
     * e.g. For 2021-06-29 and 2022-09-28:
     * * with <em>$absoluteCount</em> = true, this method will return -14
     * * with <em>$absoluteCount</em> = false, this method will return -2
     *
     * @see date_diff()
     */
    public function getMonths(bool $absoluteCount = true): int
    {
        $count = $this->dateInterval->m;

        if ($absoluteCount) {
            $count += 12 * $this->dateInterval->y;
        }

        return $this->isNegative() ? - $count : $count;
    }

    /**
     * Returns the count of COMPLETED days between the two DateTime instances of this interval.
     *
     * <u>POSITIVE VALUES</u>
     *
     * e.g. For 2021-08-28 and 2021-06-29:
     * * with <em>$absoluteCount</em> = true, this method will return 60
     * * with <em>$absoluteCount</em> = false, this method will return 30
     *
     * e.g. For 2021-08-28 and 2021-06-27:
     * * with <em>$absoluteCount</em> = true, this method will return 62
     * * with <em>$absoluteCount</em> = false, this method will return 1
     *
     * <u>NEGATIVE VALUES</u>
     *
     * e.g. For 2021-06-27 and 2021-08-28:
     * * with <em>$absoluteCount</em> = true, this method will return -62
     * * with <em>$absoluteCount</em> = false, this method will return -1
     *
     * e.g. For 2021-06-29 and 2021-08-28:
     * * with <em>$absoluteCount</em> = true, this method will return -60
     * * with <em>$absoluteCount</em> = false, this method will return -29
     *
     * e.g. For 2021-06-29 and 2022-08-28:
     * * with <em>$absoluteCount</em> = true, this method will return -425
     * * with <em>$absoluteCount</em> = false, this method will return -29
     *
     * @see date_diff()
     *
     * @throws RuntimeException
     */
    public function getDays(bool $absoluteCount = true): int
    {
        $count = $absoluteCount ? $this->dateInterval->days : $this->dateInterval->d;

        if ($count === false) {
            throw new \RuntimeException('count is false');
        }

        return $this->isNegative() ? - $count : $count;
    }

    /**
     * Returns the count of COMPLETED days between the two DateTime instances of this interval.
     *
     * <u>POSITIVE VALUES</u>
     *
     * e.g. For 2021-08-28 00:00:00 and 2021-08-27 00:00:00:
     * * with <em>$absoluteCount</em> = true, this method will return 24
     * * with <em>$absoluteCount</em> = false, this method will return 0
     *
     * e.g. For 2021-08-28 01:00:00 and 2021-08-27 00:00:00:
     * * with <em>$absoluteCount</em> = true, this method will return 25
     * * with <em>$absoluteCount</em> = false, this method will return 1
     *
     * e.g. For 2021-08-28 01:31:00 and 2021-08-27 00:00:00:
     * * with <em>$absoluteCount</em> = true, this method will return 25
     * * with <em>$absoluteCount</em> = false, this method will return 1
     *
     * <u>NEGATIVE VALUES</u>
     *
     * e.g. For 2021-08-27 00:00:00 and 2021-08-28 00:00:00:
     * * with <em>$absoluteCount</em> = true, this method will return -24
     * * with <em>$absoluteCount</em> = false, this method will return 0
     *
     * e.g. For 2021-08-27 00:00:00 and 2021-08-28 01:00:00:
     * * with <em>$absoluteCount</em> = true, this method will return -25
     * * with <em>$absoluteCount</em> = false, this method will return -1
     *
     * @see date_diff()
     */
    public function getHours(bool $absoluteCount = true): int
    {
        $count = $this->dateInterval->h;

        if ($absoluteCount) {
            $count += 24 * $this->dateInterval->days;
        }

        return $this->isNegative() ? - $count : $count;
    }

    /**
     * Returns the count of COMPLETED days between the two DateTime instances of this interval.
     *
     * <u>POSITIVE VALUES</u>
     *
     * e.g. For 2021-08-28 00:01:00 and 2021-08-27 00:00:00:
     * * with <em>$absoluteCount</em> = true, this method will return 1441
     * * with <em>$absoluteCount</em> = false, this method will return 1
     *
     * e.g. For 2021-08-28 00:01:59 and 2021-08-27 00:00:00:
     * * with <em>$absoluteCount</em> = true, this method will return 1441
     * * with <em>$absoluteCount</em> = false, this method will return 1
     *
     * <u>NEGATIVE VALUES</u>
     *
     * e.g. For 2021-08-27 00:00:00 and 2021-08-28 00:01:00:
     * * with <em>$absoluteCount</em> = true, this method will return -1441
     * * with <em>$absoluteCount</em> = false, this method will return -1
     *
     * e.g. For 2021-08-27 00:00:00 and 2021-08-28 00:01:59:
     * * with <em>$absoluteCount</em> = true, this method will return -1441
     * * with <em>$absoluteCount</em> = false, this method will return -1
     *
     * @see date_diff()
     */
    public function getMinutes(bool $absoluteCount = true): int
    {
        $count = $this->dateInterval->i;

        if ($absoluteCount) {
            $count += 60 * abs($this->getHours());
        }

        return $this->isNegative() ? - $count : $count;
    }

    /**
     * Returns the count of COMPLETED days between the two DateTime instances of this interval.
     *
     * <u>POSITIVE VALUES</u>
     *
     * e.g. For 2021-08-28 00:01:00 and 2021-08-27 23:59:00:
     * * with <em>$absoluteCount</em> = true, this method will return 120
     * * with <em>$absoluteCount</em> = false, this method will return 0
     *
     * e.g. For 2021-08-28 00:01:59 and 2021-08-27 23:59:05:
     * * with <em>$absoluteCount</em> = true, this method will return 115
     * * with <em>$absoluteCount</em> = false, this method will return 55
     *
     * <u>NEGATIVE VALUES</u>
     *
     * e.g. For 2021-08-27 23:59:00 and 2021-08-28 00:01:00:
     * * with <em>$absoluteCount</em> = true, this method will return -120
     * * with <em>$absoluteCount</em> = false, this method will return 0
     *
     * e.g. For 2021-08-27 23:59:05 and 2021-08-28 00:01:59:
     * * with <em>$absoluteCount</em> = true, this method will return -115
     * * with <em>$absoluteCount</em> = false, this method will return -55
     *
     * @see date_diff()
     */
    public function getSeconds(bool $absoluteCount = true): int
    {
        $count = $this->dateInterval->s;

        if ($absoluteCount) {
            $count += 60 * abs($this->getMinutes());
        }

        return $this->isNegative() ? - $count : $count;
    }

    /**
     * Returns the count of COMPLETED days between the two DateTime instances of this interval.
     *
     * <u>POSITIVE VALUES</u>
     *
     * e.g. For 2021-08-28 00:00:01.100 and 2021-08-27 23:59:59.100:
     * * with <em>$absoluteCount</em> = true, this method will return 2000.0
     * * with <em>$absoluteCount</em> = false, this method will return 0.0
     *
     * e.g. For 2021-08-28 00:00:01.100 and 2021-08-27 23:59:59.000:
     * * with <em>$absoluteCount</em> = true, this method will return 2000.1
     * * with <em>$absoluteCount</em> = false, this method will return 0.1
     *
     * <u>NEGATIVE VALUES</u>
     *
     * e.g. For 2021-08-27 23:59:59.100 and 2021-08-28 00:00:01.100:
     * * with <em>$absoluteCount</em> = true, this method will return -2000.0
     * * with <em>$absoluteCount</em> = false, this method will return -0.0
     *
     * e.g. For 2021-08-27 23:59:59.000 and 2021-08-28 00:00:01.100:
     * * with <em>$absoluteCount</em> = true, this method will return -1999.9
     * * with <em>$absoluteCount</em> = false, this method will return -0.1
     *
     * @see date_diff()
     */
    public function getMicroSeconds(bool $absoluteCount = true): float
    {
        $count = $this->dateInterval->f;

        if ($absoluteCount) {
            $count += 1000 * abs($this->getSeconds());
        }

        return $this->isNegative() ? - $count : $count;
    }

    /**
     * @return bool
     */
    public function isNegative(): bool
    {
        return (bool)$this->dateInterval->invert;
    }

    /**
     * @see DateTimeInterval::format() for accepted format.
     *
     * @codeCoverageIgnore
     */
    public function format(string $format): string
    {
        return $this->dateInterval->format($format);
    }

    /**
     * @return DateInterval|false
     *
     * @codeCoverageIgnore
     */
    public function getDateInterval()
    {
        return $this->dateInterval;
    }
}
