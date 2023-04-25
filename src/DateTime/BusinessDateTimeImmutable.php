<?php

namespace Business\DateTime;

use DateTimeImmutable;

class BusinessDateTimeImmutable extends DateTimeImmutable implements BusinessDateTimeInterface
{

    use BusinessDateTimeTrait {
        setHolidays as public setHolidaysTrait;
        setNonBusinessDays as public setNonBusinessDaysTrait;
        setWorkingDays as public setWorkingDaysTrait;
    }

    public function setHolidays(array $holidays): static
    {
        $this->setHolidaysTrait($holidays);
        return clone $this;
    }

    public function setNonBusinessDays(array $non_business_days): static
    {
        $this->setNonBusinessDaysTrait($non_business_days);
        return clone $this;
    }

    public function setWorkingDays(array $working_days): static
    {
        $this->setWorkingDaysTrait($working_days);
        return clone $this;
    }

    public function addBusinessDays(int $number_of_days): static
    {
        // To keep immutability
        $clone = clone $this;

        $i = 0;
        while ($i < $number_of_days) {
            $clone = $clone->modify('+1 day');

            if ($clone->isBusinessDay()) {
                $i++;
            }
        }

        return $clone;
    }
}