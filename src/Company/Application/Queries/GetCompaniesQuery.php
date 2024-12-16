<?php

declare(strict_types=1);

namespace Src\Company\Application\Queries;

use Src\Company\Domain\Collections\Companies;
use Src\Company\Domain\CompanyRepositoryInterface;

final readonly class GetCompaniesQuery
{
    public function __construct(private CompanyRepositoryInterface $repository) {}

    public function get(): Companies
    {
        return $this->repository->findAll();
    }
}
