<?php

namespace Business\DateTime;

use DateTimeInterface;
use DateTimeZone;
use InvalidArgumentException;

/**
 * @method static static|bool createFromFormat(string $format, string $datetime, ?DateTimeZone $timezone = null)
 * @method static static createFromInterface(DateTimeInterface $object)
 */
trait BusinessDateTimeTrait
{

    /** @var DateTimeInterface[] $holidays */
    protected array $holidays = [];

    /** @var int[] $non_business_days */
    protected array $non_business_days = [];

    public static function __callStatic(string $name, array $arguments): static
    {
        return new static(parent::{$name}($arguments)->format(DateTimeInterface::ATOM));
    }

    public static function __set_state($array): static
    {
        $parent = parent::__set_state($array);
        return new static($parent->format(DateTimeInterface::ATOM));
    }

    /**
     * @param DateTimeInterface[] $holidays
     * @return static
     */
    public function setHolidays(array $holidays): static
    {
        foreach ($holidays as $holiday) {
            if (!$holiday instanceof DateTimeInterface) {
                throw new InvalidArgumentException('Holidays must be instances of DateTimeInterface');
            }
        }

        $this->holidays = $holidays;
        return $this;
    }

    /**
     * @return DateTimeInterface[]
     */
    public function getHolidays(): array
    {
        return $this->holidays;
    }

    /**
     * @param int[] $non_business_days
     * @return BusinessDateTimeImmutable
     */
    public function setNonBusinessDays(array $non_business_days): static
    {
        $this->containsOnlyValidDays($non_business_days);
        $this->non_business_days = $non_business_days;

        return $this;
    }

    /**
     * @return int[]
     */
    public function getNonBusinessDays(): array
    {
        return $this->non_business_days;
    }

    public function setWorkingDays(array $working_days): static
    {
        $non_business_days = [];
        foreach (range(1, 7) as $day) {
            if (!in_array($day, $working_days)) {
                $non_business_days[] = $day;
            }
        }

        return $this->setNonBusinessDays($non_business_days);
    }

    /**
     * @return int[]
     */
    public function getWorkingDays(): array
    {
        return array_values(array_filter(
            [
                BusinessDateTime::MONDAY,
                BusinessDateTime::TUESDAY,
                BusinessDateTime::WEDNESDAY,
                BusinessDateTime::THURSDAY,
                BusinessDateTime::FRIDAY,
                BusinessDateTime::SATURDAY,
                BusinessDateTime::SUNDAY
            ],
            fn($day) => !in_array($day, $this->non_business_days)
        ));
    }

    private function containsOnlyValidDays(array $days): void
    {
        $valid_days = range(1, 7);
        foreach ($days as $day) {
            if (!in_array($day, $valid_days)) {
                throw new InvalidArgumentException('Non business days must be in range 1..7');
            }
        }
    }

    protected function isBusinessDay(): bool
    {
        if (in_array((int)$this->format('N'), $this->non_business_days)) {
            return false;
        }

        foreach ($this->holidays as $day) {
            if ($this->format('Y-m-d') == $day->format('Y-m-d')) {
                return false;
            }
        }

        return true;
    }
}