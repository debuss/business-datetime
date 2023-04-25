<a name="readme-top"></a>

<div align="center">
<h3 align="center">Business DateTime</h3>

  <p align="center">
    A DateTime implementation to help you calculate DateTime in business days.
    <br />
    <br />
    <a href="https://github.com/debuss/business-datetime/issues">Report Bug</a>
    ·
    <a href="https://github.com/debuss/business-datetime/issues">Request Feature</a>
  </p>
</div>

<details>
  <summary>Table of Contents</summary>
  <ol>
    <li>
      <a href="#getting-started">Getting Started</a>
      <ul>
        <li><a href="#prerequisites">Prerequisites</a></li>
        <li><a href="#installation">Installation</a></li>
      </ul>
    </li>
    <li><a href="#usage">Usage</a></li>
    <li><a href="#contributing">Contributing</a></li>
    <li><a href="#license">License</a></li>
    <li><a href="#acknowledgments">Acknowledgments</a></li>
  </ol>
</details>

## Getting Started

Use [composer](https://getcomposer.org) to add this package to your project.

### Prerequisites

* PHP v8+

### Installation

In your project root folder:

```sh
composer require debuss-a/business-datetime
```

<p align="right">(<a href="#readme-top">back to top</a>)</p>

## Usage

You can define a starting date, setup working days and holidays, then add a number of business day to your starting date.

You'll easily be able to know the exact date you need in business days.

```php
use Business\DateTime\BusinessDateTime;

$business_day = new BusinessDateTime('2023-04-25');
$business_day
    ->setNonBusinessDays([
        BusinessDateTime::SATURDAY,
        BusinessDateTime::SUNDAY
    ])
    // Or
    // ->setWorkingDays([
    //     BusinessDateTime::MONDAY,
    //     BusinessDateTime::TUESDAY,
    //     BusinessDateTime::WEDNESDAY,
    //     BusinessDateTime::THURSDAY,
    //     BusinessDateTime::FRIDAY
    // ])
    ->setHolidays([
        new DateTime('2023-05-01'),
        new DateTime('2023-05-08')
    ])
    ->addBusinessDays(14);

var_dump($business_day->format('Y-m-d'));
// --> 2023-05-17
```

<p align="right">(<a href="#readme-top">back to top</a>)</p>

## Contributing

Contributions are what make the open source community such an amazing place to learn, inspire, and create. Any contributions you make are **greatly appreciated**.

If you have a suggestion that would make this better, please fork the repo and create a pull request. You can also simply open an issue with the tag "enhancement".
Don't forget to give the project a star! Thanks again!

1. Fork the Project
2. Create your Feature Branch (`git checkout -b feature/AmazingFeature`)
3. Commit your Changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the Branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

<p align="right">(<a href="#readme-top">back to top</a>)</p>

## License

Distributed under the MIT License. See `LICENSE` file for more information.

<p align="right">(<a href="#readme-top">back to top</a>)</p>

## Acknowledgments

* [PHP DateTime class](https://www.php.net/manual/fr/class.datetime.php)
* [PHP DateTimeImmutable class](https://www.php.net/manual/fr/class.datetimeimmutable.php)

<p align="right">(<a href="#readme-top">back to top</a>)</p>