<?php

declare(strict_types=1);

namespace Src\Company\Infrastructure\Eloquent\Repositories;

use Src\Company\Domain\Collections\Companies;
use Src\Company\Domain\Company;
use Src\Company\Domain\CompanyRepositoryInterface;
use Src\Company\Domain\ValueObjects\CompanyId;
use Src\Company\Infrastructure\Eloquent\Models\CompanyEloquentModel;

final readonly class CompanyEloquentRepository implements CompanyRepositoryInterface
{
    public function findAll(): Companies
    {
        // TODO: Implement findAll() method.
    }

    public function findById(CompanyId $id): ?Company
    {
        return CompanyEloquentModel::query()->find($id)?->toEntity();
    }

    public function save(Company $company): void
    {
        CompanyEloquentModel::query()->updateOrCreate(['id' => $company->id], [
            'id' => $company->id,
            'name' => $company->name,
            'nip' => $company->companyNip,
            'address' => $company->address->address,
            'city' => $company->address->city,
            'postal_code' => $company->address->postalCode,
        ]);
    }

    public function delete(Company $company): void
    {
        // TODO: Implement delete() method.
    }
}
