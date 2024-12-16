<?php

declare(strict_types=1);

namespace Src\Company\UI\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Ramsey\Uuid\Uuid;
use Src\Company\Application\Queries\FindCompanyQuery;
use Src\Company\Application\Queries\GetCompaniesQuery;
use Src\Company\Application\UseCases\Create\CreateCompanyCommand;
use Src\Company\Application\UseCases\Delete\DeleteCompanyCommand;
use Src\Company\Application\UseCases\Update\UpdateCompanyCommand;
use Src\Company\Domain\Exceptions\CompanyNotFound;
use Src\Company\UI\Http\Requests\CreateCompanyRequest;
use Src\Company\UI\Http\Requests\UpdateCompanyRequest;
use Src\Company\UI\Http\Resources\CompanyResource;
use Src\Company\UI\Http\Resources\CompanyResourceCollection;
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

    public function index(GetCompaniesQuery $query): CompanyResourceCollection
    {
        return new CompanyResourceCollection($query->get());
    }

    public function get(string $id, FindCompanyQuery $query): CompanyResource
    {
        try {
            return new CompanyResource($query->get($id));
        } catch (CompanyNotFound $e) {
            abort(404, $e->getMessage());
        }
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
        try {

            $this->commandHandler->handle(
                new DeleteCompanyCommand(
                    $id,
                )
            );

            return new JsonResponse;

        } catch (CompanyNotFound $e) {
            return new JsonResponse($e->getMessage(), JsonResponse::HTTP_NOT_FOUND);
        }
    }
}
