<?php

declare(strict_types=1);

namespace Src\Company\Application\Update;

use Src\Company\Domain\CompanyFullAddress;
use Src\Company\Domain\CompanyRepositoryInterface;
use Src\Company\Domain\Finders\CompanyFinder;
use Src\Company\Domain\ValueObjects\CompanyId;
use Src\Company\Domain\ValueObjects\CompanyName;
use Src\Shared\Domain\Bus\EventBusInterface;

final readonly class CompanyUpdater {

    public function __construct(
        private CompanyRepositoryInterface $repository,
        private EventBusInterface $eventBus, private CompanyFinder $finder)
    {
    }

    public function update(CompanyId $id, CompanyName $name, CompanyFullAddress $fullAddress): void
    {
        $company = $this->finder->find($id);

        $company->update($name, $fullAddress);
        $this->repository->save($company);
        $this->eventBus->publish(...$company->pullDomainEvents());
    }
}
