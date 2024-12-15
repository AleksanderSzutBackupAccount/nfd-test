<?php

declare(strict_types=1);

namespace Src\Company\Application\Create;

use Src\Company\Domain\CompanyFullAddress;
use Src\Company\Domain\ValueObjects\CompanyAddress;
use Src\Company\Domain\ValueObjects\CompanyCity;
use Src\Company\Domain\ValueObjects\CompanyId;
use Src\Company\Domain\ValueObjects\CompanyName;
use Src\Company\Domain\ValueObjects\CompanyNip;
use Src\Company\Domain\ValueObjects\CompanyPostalCode;

final readonly class CreateCompanyHandler
{
    public function __construct(
        private CompanyCreator $companyCreator,
    ) {}

    public function handle(CreateCompanyCommand $command): void
    {
        $this->companyCreator->create(
            new CompanyId($command->id),
            new CompanyName($command->name),
            new CompanyNip($command->nip),
            new CompanyFullAddress(
                new CompanyCity($command->city),
                new CompanyPostalCode($command->postalCode),
                new CompanyAddress($command->address)
            )
        );
    }
}
