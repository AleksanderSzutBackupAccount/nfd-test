<?php

declare(strict_types=1);

namespace Src\CompanyEmployee\Domain;

use Src\Company\Domain\ValueObjects\CompanyId;
use Src\CompanyEmployee\Domain\Events\EmployeeCreatedEvent;
use Src\CompanyEmployee\Domain\Events\EmployeeUpdatedEvent;
use Src\CompanyEmployee\Domain\ValueObjects\EmployeeEmail;
use Src\CompanyEmployee\Domain\ValueObjects\EmployeeFirstName;
use Src\CompanyEmployee\Domain\ValueObjects\EmployeeId;
use Src\CompanyEmployee\Domain\ValueObjects\EmployeeLastName;
use Src\CompanyEmployee\Domain\ValueObjects\EmployeePhone;
use Src\Shared\Domain\Aggregate\AggregateRoot;

final class Employee extends AggregateRoot
{
    public function __construct(
        public readonly EmployeeId $id,
        public EmployeeFirstName $firstName,
        public EmployeeLastName $lastName,
        public EmployeeEmail $email,
        public ?EmployeePhone $phone,
        public readonly CompanyId $companyId,
    ) {}

    public static function create(
        EmployeeId $id,
        EmployeeFirstName $firstName,
        EmployeeLastName $lastName,
        EmployeeEmail $email,
        ?EmployeePhone $phone,
        CompanyId $companyId,
    ): self {
        $company = new self($id, $firstName, $lastName, $email, $phone, $companyId);

        $company->record(new EmployeeCreatedEvent($id));

        return $company;
    }

    public function update(
        EmployeeFirstName $firstName,
        EmployeeLastName $lastName,
        EmployeeEmail $email,
        ?EmployeePhone $phone,
    ): void {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->phone = $phone;

        $this->record(new EmployeeUpdatedEvent($this->id));
    }
}
