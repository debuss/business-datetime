<?php

namespace Business\DateTime;
use DateTimeInterface;

interface BusinessDateTimeInterface
{

    const MONDAY = 1;
    const TUESDAY = 2;
    const WEDNESDAY = 3;
    const THURSDAY = 4;
    const FRIDAY = 5;
    const SATURDAY = 6;
    const SUNDAY = 7;

    public function addBusinessDays(int $number_of_days): static;
}