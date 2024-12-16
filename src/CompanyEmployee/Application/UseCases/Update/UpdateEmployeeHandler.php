<?php

declare(strict_types=1);

namespace Src\CompanyEmployee\Application\UseCases\Update;

use Src\CompanyEmployee\Domain\ValueObjects\EmployeeEmail;
use Src\CompanyEmployee\Domain\ValueObjects\EmployeeFirstName;
use Src\CompanyEmployee\Domain\ValueObjects\EmployeeId;
use Src\CompanyEmployee\Domain\ValueObjects\EmployeeLastName;
use Src\CompanyEmployee\Domain\ValueObjects\EmployeePhone;
use Src\Shared\Domain\Bus\CommandInterface;

final readonly class UpdateEmployeeHandler implements CommandInterface
{
    public function __construct(
        private EmployeeUpdater $employeeUpdater,
    ) {}

    public function handle(UpdateEmployeeCommand $command): void
    {
        $this->employeeUpdater->update(
            new EmployeeId($command->id),
            new EmployeeFirstName($command->firstName),
            new EmployeeLastName($command->lastName),
            new EmployeeEmail($command->email),
            EmployeePhone::fromNullable($command->phone),
        );
    }
}
