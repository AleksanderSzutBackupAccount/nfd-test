<?php

declare(strict_types=1);

namespace Src\Company\UI\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Src\Company\Infrastructure\Eloquent\CompanyEloquentModel;

final class CompanyController extends Controller
{
    public function create(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'nip' => 'required|string|unique:companies',
            'address' => 'required|string',
            'city' => 'required|string',
            'postal_code' => 'required|string',
        ]);

        CompanyEloquentModel::query()->create($validated);

        return new JsonResponse([], JsonResponse::HTTP_CREATED);
    }

    public function index(): JsonResponse
    {
        return new JsonResponse(CompanyEloquentModel::all()->toArray());
    }

    public function get(int $id): JsonResponse
    {
        /** @var CompanyEloquentModel $company */
        $company = CompanyEloquentModel::query()->findOrFail($id);

        return new JsonResponse($company->toArray());
    }

    public function update(Request $request, int $id): JsonResponse
    {
        /** @var CompanyEloquentModel $company */
        $company = CompanyEloquentModel::query()->findOrFail($id);
        $validated = $request->validate([
            'name' => 'string',
            'address' => 'string',
            'city' => 'string',
            'postal_code' => 'string',
        ]);
        $company->update($validated);

        return new JsonResponse([]);
    }

    public function delete(int $id): JsonResponse
    {
        /** @var CompanyEloquentModel $company */
        $company = CompanyEloquentModel::query()->findOrFail($id);
        $company->deleteOrFail();

        return new JsonResponse([]);
    }
}
