<?php

declare(strict_types=1);

namespace Src\CompanyEmployee\Application\UseCases\Delete;

use Src\Shared\Domain\Bus\CommandInterface;

final readonly class DeleteEmployeeCommand implements CommandInterface
{
    public function __construct(
        public string $id,
    ) {}
}
