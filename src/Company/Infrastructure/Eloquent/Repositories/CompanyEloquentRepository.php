<?php

declare(strict_types=1);

namespace Src\Company\Infrastructure\Eloquent\Repositories;

use Src\Company\Domain\Collections\Companies;
use Src\Company\Domain\Company;
use Src\Company\Domain\CompanyRepositoryInterface;
use Src\Company\Domain\Exceptions\CompanyNotFound;
use Src\Company\Domain\ValueObjects\CompanyId;
use Src\Company\Infrastructure\Eloquent\Models\CompanyEloquentModel;

final readonly class CompanyEloquentRepository implements CompanyRepositoryInterface
{
    public function findAll(): Companies
    {
        $models = CompanyEloquentModel::all();

        $companies = new Companies([]);

        foreach ($models as $company) {
            $companies->push($company->toEntity());
        }

        return $companies;
    }

    public function findById(CompanyId $id): ?Company
    {
        $company = CompanyEloquentModel::query()->find($id);
        if ($company === null) {
            return null;
        }

        return $company->toEntity();
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

    /**
     * @throws \Throwable
     */
    public function delete(CompanyId $id): void
    {
        $company = CompanyEloquentModel::query()->find($id);

        if (! $company) {
            throw new CompanyNotFound($id);
        }

        $company->deleteOrFail();
    }
}
