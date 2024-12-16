<?php

declare(strict_types=1);

namespace Src\CompanyEmployee\Application\UseCases\Update;

use Src\CompanyEmployee\Domain\EmployeeRepositoryInterface;
use Src\CompanyEmployee\Domain\Finders\EmployeeFinder;
use Src\CompanyEmployee\Domain\ValueObjects\EmployeeEmail;
use Src\CompanyEmployee\Domain\ValueObjects\EmployeeFirstName;
use Src\CompanyEmployee\Domain\ValueObjects\EmployeeId;
use Src\CompanyEmployee\Domain\ValueObjects\EmployeeLastName;
use Src\CompanyEmployee\Domain\ValueObjects\EmployeePhone;
use Src\Shared\Domain\Bus\EventBusInterface;

final readonly class EmployeeUpdater
{
    public function __construct(
        private EmployeeRepositoryInterface $repository,
        private EventBusInterface $eventBus,
        private EmployeeFinder $finder) {}

    public function update(EmployeeId $id, EmployeeFirstName $firstName, EmployeeLastName $lastName, EmployeeEmail $email, ?EmployeePhone $phone): void
    {
        $company = $this->finder->find($id);

        $company->update($firstName, $lastName, $email, $phone);

        $this->repository->save($company);
        $this->eventBus->publish(...$company->pullDomainEvents());
    }
}
