<?php

declare(strict_types=1);

namespace Src\Company\Domain;

use Src\Company\Domain\ValueObjects\CompanyAddress;
use Src\Company\Domain\ValueObjects\CompanyCity;
use Src\Company\Domain\ValueObjects\CompanyPostalCode;

final readonly class CompanyFullAddress
{
    public function __construct(
        public CompanyCity $city,
        public CompanyPostalCode $postalCode,
        public CompanyAddress $address,
    ) {}
}
