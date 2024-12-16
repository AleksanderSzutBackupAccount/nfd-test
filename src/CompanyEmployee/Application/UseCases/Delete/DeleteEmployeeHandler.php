<?php

declare(strict_types=1);

namespace Src\CompanyEmployee\Application\UseCases\Delete;

use Src\CompanyEmployee\Domain\EmployeeRepositoryInterface;
use Src\CompanyEmployee\Domain\ValueObjects\EmployeeId;
use Src\Shared\Domain\Bus\CommandInterface;

final readonly class DeleteEmployeeHandler implements CommandInterface
{
    public function __construct(
        private EmployeeRepositoryInterface $repository,
    ) {}

    public function handle(DeleteEmployeeCommand $command): void
    {
        $this->repository->delete(new EmployeeId($command->id));
    }
}
