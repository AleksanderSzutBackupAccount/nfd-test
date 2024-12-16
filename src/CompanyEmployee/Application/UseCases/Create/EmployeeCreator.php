<?php

declare(strict_types=1);

namespace Src\CompanyEmployee\Application\UseCases\Create;

use Src\Company\Domain\ValueObjects\CompanyId;
use Src\CompanyEmployee\Domain\Employee;
use Src\CompanyEmployee\Domain\EmployeeRepositoryInterface;
use Src\CompanyEmployee\Domain\ValueObjects\EmployeeEmail;
use Src\CompanyEmployee\Domain\ValueObjects\EmployeeFirstName;
use Src\CompanyEmployee\Domain\ValueObjects\EmployeeId;
use Src\CompanyEmployee\Domain\ValueObjects\EmployeeLastName;
use Src\CompanyEmployee\Domain\ValueObjects\EmployeePhone;
use Src\Shared\Domain\Bus\EventBusInterface;

final readonly class EmployeeCreator
{
    public function __construct(
        private EmployeeRepositoryInterface $repository,
        private EventBusInterface $eventBus,
    ) {}

    public function create(EmployeeId $id, EmployeeFirstName $firstName, EmployeeLastName $lastName, EmployeeEmail $email, ?EmployeePhone $phone, CompanyId $companyId): void
    {
        $employee = Employee::create($id, $firstName, $lastName, $email, $phone, $companyId);

        $this->repository->save($employee);
        $this->eventBus->publish(...$employee->pullDomainEvents());
    }
}
