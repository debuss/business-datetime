<?php

use Business\DateTime\BusinessDateTime;

test('Method setHolidays() accept valid holidays', function () {
    $holidays = [
        new DateTime('25 december 2022'),
        new DateTime('1 january 2023')
    ];

    $this->business_datetime->setHolidays($holidays);

    expect($this->business_datetime->getHolidays())
        ->toBeArray()
        ->toHaveCount(count($holidays))
        ->toMatchArray($holidays);
});

test('Method setHolidays() throw exception when item is not an instance of DateTimeInterface', function () {
    $this->business_datetime->setHolidays([
        new DateTime(),
        42
    ]);
})->expectException(InvalidArgumentException::class);

test('Method setNonBusinessDays() accept valid days', function () {
    $non_business_days = [BusinessDateTime::SATURDAY, BusinessDateTime::SUNDAY];
    $this->business_datetime->setNonBusinessDays($non_business_days);

    expect($this->business_datetime->getNonBusinessDays())
        ->toBeArray()
        ->toHaveCount(count($non_business_days))
        ->toMatchArray($non_business_days);
});

test('Method setNonBusinessDays() throw exception when item is not a valid day', function () {
    $this->business_datetime->setNonBusinessDays([1, 2, 42, 5]);
})->expectException(InvalidArgumentException::class);

test('Method setWorkingDays() accept valid days', function () {
    $business_days = [
        BusinessDateTime::MONDAY,
        BusinessDateTime::TUESDAY,
        BusinessDateTime::THURSDAY,
        BusinessDateTime::FRIDAY
    ];
    $this->business_datetime->setWorkingDays($business_days);

    expect($this->business_datetime->getWorkingDays())
        ->toBeArray()
        ->toHaveCount(count($business_days))
        ->toMatchArray($business_days);
});

test('Method setWorkingDays() auto filter when item is not a valid day', function () {
    $this->business_datetime->setWorkingDays([1, 2, 42, 5]);
    expect($this->business_datetime->getWorkingDays())
        ->toBeArray()
        ->toHaveCount(3)
        ->toMatchArray([1, 2, 5]);
});

test('Method isBusinessDay() return true on working day', function () {
    $business_datetime = new class extends BusinessDateTime {
        public function testIsBusinessDay()
        {
            return $this->isBusinessDay();
        }
    };

    expect($business_datetime->testIsBusinessDay())->toBeTrue();
});

test('Method isBusinessDay() return false on non-working day', function () {
    $business_datetime = new class extends BusinessDateTime {
        public function testIsBusinessDay()
        {
            return $this->isBusinessDay();
        }
    };

    $business_datetime->setNonBusinessDays(range(1, 7));

    expect($business_datetime->testIsBusinessDay())->toBeFalse();
});

test('Method addBusinessDays() takes non-business days and holidays in consideration', function () {
    $this->business_datetime
        ->setHolidays([
            new DateTime('18 April 2023'),
            new DateTime('19 April 2023')
        ])
        ->setNonBusinessDays([
            BusinessDateTime::SATURDAY,
            BusinessDateTime::SUNDAY
        ])
        ->addBusinessDays(14);

    expect($this->business_datetime->format('Y-m-d'))->toBe('2023-05-09');
});

test('Method createFromFormat() returns a DateTimeBusiness instance', function () {
    expect(BusinessDateTime::createFromFormat('m F Y', '17 April 2023'))
        ->toBeInstanceOf(BusinessDateTime::class);
});

test('Method createFromInterface() returns a DateTimeBusiness instance', function () {
    $date = new DateTimeImmutable('2014-06-20 11:45 Europe/London');

    expect(BusinessDateTime::createFromInterface($date))
        ->toBeInstanceOf(BusinessDateTime::class);
});
