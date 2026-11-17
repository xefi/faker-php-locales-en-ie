<?php

namespace Xefi\Faker\EnIe;

use Xefi\Faker\EnIe\Extensions\AddressExtension;
use Xefi\Faker\EnIe\Extensions\ColorsExtension;
use Xefi\Faker\EnIe\Extensions\CompanyExtension;
use Xefi\Faker\EnIe\Extensions\FinancialExtension;
use Xefi\Faker\EnIe\Extensions\PersonExtension;
use Xefi\Faker\EnIe\Extensions\PhoneExtension;
use Xefi\Faker\EnIe\Extensions\TextExtension;
use Xefi\Faker\Providers\Provider;

class FakerEnIeServiceProvider extends Provider
{
    public function boot(): void
    {
        $this->extensions([
            AddressExtension::class,
            ColorsExtension::class,
            CompanyExtension::class,
            FinancialExtension::class,
            PersonExtension::class,
            PhoneExtension::class,
            TextExtension::class,
        ]);
    }
}
