<?php

declare(strict_types=1);

namespace Src\CompanyEmployee\Application\UseCases\Create;

use Src\CompanyEmployee\Domain\ValueObjects\EmployeeEmail;
use Src\CompanyEmployee\Domain\ValueObjects\EmployeeFirstName;
use Src\CompanyEmployee\Domain\ValueObjects\EmployeeId;
use Src\CompanyEmployee\Domain\ValueObjects\EmployeeLastName;
use Src\CompanyEmployee\Domain\ValueObjects\EmployeePhone;

final readonly class CreateEmployeeHandler
{
    public function __construct(
        private EmployeeCreator $employeeCreator,
    ) {}

    public function handle(CreateEmployeeCompanyCommand $command): void
    {
        $this->employeeCreator->create(
            new EmployeeId($command->id),
            new EmployeeFirstName($command->firstName),
            new EmployeeLastName($command->lastName),
            new EmployeeEmail($command->email),
            EmployeePhone::fromNullable($command->phone),
            $command->companyId
        );
    }
}
