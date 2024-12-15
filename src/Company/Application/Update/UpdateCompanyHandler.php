<?php

declare(strict_types=1);

namespace Src\Company\Application\Update;

use Src\Company\Application\Create\CompanyCreator;
use Src\Company\Application\Create\CreateCompanyCommand;
use Src\Company\Domain\CompanyFullAddress;
use Src\Company\Domain\ValueObjects\CompanyAddress;
use Src\Company\Domain\ValueObjects\CompanyCity;
use Src\Company\Domain\ValueObjects\CompanyId;
use Src\Company\Domain\ValueObjects\CompanyName;
use Src\Company\Domain\ValueObjects\CompanyPostalCode;
use Src\Shared\Domain\Bus\CommandInterface;

final readonly class UpdateCompanyHandler implements CommandInterface {
    public function __construct(
        private CompanyUpdater $companyUpdater,
    ) {}

    public function handle(UpdateCompanyCommand $command): void
    {
        $this->companyUpdater->update(
            new CompanyId($command->id),
            new CompanyName($command->name),
            new CompanyFullAddress(
                new CompanyCity($command->city),
                new CompanyPostalCode($command->postalCode),
                new CompanyAddress($command->address)
            )
        );
    }
}
