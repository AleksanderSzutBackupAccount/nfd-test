<?php

declare(strict_types=1);

namespace Src\CompanyEmployee\Application\UseCases\Update;

use Src\Shared\Domain\Bus\CommandInterface;

final readonly class UpdateEmployeeCommand implements CommandInterface
{
    public function __construct(
        public string $id,
        public string $firstName,
        public string $lastName,
        public string $email,
        public ?string $phone,
    ) {}
}
