<?php

namespace Business\DateTime;

use DateTime;

class BusinessDateTime extends DateTime implements BusinessDateTimeInterface
{

    use BusinessDateTimeTrait;

    public function addBusinessDays(int $number_of_days): static
    {
        $i = 0;
        while ($i < $number_of_days) {
            $this->modify('+1 day');

            if ($this->isBusinessDay()) {
                $i++;
            }
        }

        return $this;
    }
}
