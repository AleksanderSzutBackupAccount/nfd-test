<?php

declare(strict_types=1);

namespace Src\Company\UI\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use Src\Company\Application\Create\CreateCompanyCommand;
use Src\Company\Application\Update\UpdateCompanyCommand;
use Src\Company\Domain\Exceptions\CompanyNotFound;
use Src\Company\Infrastructure\Eloquent\Models\CompanyEloquentModel;
use Src\Company\UI\Http\Requests\CreateCompanyRequest;
use Src\Company\UI\Http\Requests\UpdateCompanyRequest;
use Src\Shared\Application\Bus\CommandHandlerInterface;

final class CompanyController extends Controller
{
    public function __construct(private CommandHandlerInterface $commandHandler) {}

    public function create(CreateCompanyRequest $request): JsonResponse
    {
        $this->commandHandler->handle(
            new CreateCompanyCommand(
                Uuid::uuid4()->toString(),
                $request->name,
                $request->nip,
                $request->city,
                $request->postal_code,
                $request->address
            )
        );
        return new JsonResponse([], JsonResponse::HTTP_CREATED);
    }

    public function index(): JsonResponse
    {
        return new JsonResponse(CompanyEloquentModel::all()->toArray());
    }

    public function get(string $id): JsonResponse
    {
        /** @var CompanyEloquentModel $company */
        $company = CompanyEloquentModel::query()->findOrFail($id);

        return new JsonResponse($company->toArray());
    }

    public function update(UpdateCompanyRequest $request, string $id): JsonResponse
    {
        try {
            $this->commandHandler->handle(
                new UpdateCompanyCommand(
                    $id,
                    $request->name,
                    $request->city,
                    $request->postal_code,
                    $request->address
                )
            );
            return new JsonResponse([]);
        } catch (CompanyNotFound $exception) {
            return new JsonResponse($exception->getMessage(), JsonResponse::HTTP_NOT_FOUND);
        }
    }

    public function delete(string $id): JsonResponse
    {
        /** @var CompanyEloquentModel $company */
        $company = CompanyEloquentModel::query()->findOrFail($id);
        $company->deleteOrFail();

        return new JsonResponse([]);
    }
}
