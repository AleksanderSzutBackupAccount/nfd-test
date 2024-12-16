<?php

declare(strict_types=1);

namespace Src\Company\Application\UseCases\Delete;

use Src\Company\Domain\CompanyRepositoryInterface;
use Src\Company\Domain\ValueObjects\CompanyId;
use Src\Shared\Domain\Bus\CommandInterface;

final readonly class DeleteCompanyHandler implements CommandInterface
{
    public function __construct(
        private CompanyRepositoryInterface $repository,
    ) {}

    public function handle(DeleteCompanyCommand $command): void
    {
        $this->repository->delete(new CompanyId($command->id));
    }
}
