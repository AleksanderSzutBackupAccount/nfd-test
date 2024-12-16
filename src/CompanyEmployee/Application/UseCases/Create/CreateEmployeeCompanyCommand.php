<?php

declare(strict_types=1);

namespace Src\CompanyEmployee\Application\UseCases\Create;

use Src\Company\Domain\ValueObjects\CompanyId;
use Src\Shared\Domain\Bus\CommandInterface;

final readonly class CreateEmployeeCompanyCommand implements CommandInterface
{
    public function __construct(
        public string $id,
        public string $firstName,
        public string $lastName,
        public string $email,
        public ?string $phone,
        public CompanyId $companyId,
    ) {}
}
