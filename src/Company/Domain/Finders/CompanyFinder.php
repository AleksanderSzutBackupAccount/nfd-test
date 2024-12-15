<?php

declare(strict_types=1);

namespace Src\Company\Domain\Finders;

use Src\Company\Domain\Company;
use Src\Company\Domain\CompanyRepositoryInterface;
use Src\Company\Domain\Exceptions\CompanyNotFound;
use Src\Company\Domain\ValueObjects\CompanyId;

final readonly class CompanyFinder
{
    public function __construct(private CompanyRepositoryInterface $companyRepository) {}

    /**
     * @throws CompanyNotFound
     */
    public function find(CompanyId $id): Company
    {
        $company = $this->companyRepository->findById($id);
        if ($company === null) {
            throw new CompanyNotFound($id);
        }

        return $company;
    }
}
