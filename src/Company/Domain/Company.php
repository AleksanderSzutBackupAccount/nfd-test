<?php

declare(strict_types=1);

namespace Src\Company\Domain;

use Src\Company\Domain\Events\CompanyCreatedEvent;
use Src\Company\Domain\ValueObjects\CompanyId;
use Src\Company\Domain\ValueObjects\CompanyName;
use Src\Company\Domain\ValueObjects\CompanyNip;
use Src\Shared\Domain\Aggregate\AggregateRoot;

final class Company extends AggregateRoot
{
    public function __construct(
        public readonly CompanyId $id,
        public readonly CompanyName $name,
        public readonly CompanyNip $companyNip,
        public readonly CompanyFullAddress $address,
    ) {}

    public static function create(
        CompanyId $id,
        CompanyName $name,
        CompanyNip $companyNip,
        CompanyFullAddress $address,
    ): self {
        $company = new self($id, $name, $companyNip, $address);

        $company->record(new CompanyCreatedEvent($id));

        return $company;
    }
}
