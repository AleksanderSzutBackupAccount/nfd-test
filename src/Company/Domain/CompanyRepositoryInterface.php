<?php

declare(strict_types=1);

namespace Src\Company\Domain;

use Src\Company\Domain\Collections\Companies;
use Src\Company\Domain\ValueObjects\CompanyId;

interface CompanyRepositoryInterface
{
    public function findAll(): Companies;

    public function findById(CompanyId $id): ?Company;

    public function save(Company $company): void;

    public function delete(CompanyId $id): void;
}
