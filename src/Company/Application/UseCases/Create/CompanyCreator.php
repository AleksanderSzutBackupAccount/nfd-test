<?php

declare(strict_types=1);

namespace Src\Company\Application\UseCases\Create;

use Src\Company\Domain\Company;
use Src\Company\Domain\CompanyFullAddress;
use Src\Company\Domain\CompanyRepositoryInterface;
use Src\Company\Domain\ValueObjects\CompanyId;
use Src\Company\Domain\ValueObjects\CompanyName;
use Src\Company\Domain\ValueObjects\CompanyNip;
use Src\Shared\Domain\Bus\EventBusInterface;

final readonly class CompanyCreator
{
    public function __construct(
        private CompanyRepositoryInterface $repository,
        private EventBusInterface $eventBus,
    ) {}

    public function create(CompanyId $id, CompanyName $name, CompanyNip $nip, CompanyFullAddress $fullAddress): void
    {
        $company = Company::create($id, $name, $nip, $fullAddress);

        $this->repository->save($company);
        $this->eventBus->publish(...$company->pullDomainEvents());
    }
}
