<?php

declare(strict_types=1);

namespace Src\CompanyEmployee\UI\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Ramsey\Uuid\Uuid;
use Src\Company\Domain\ValueObjects\CompanyId;
use Src\CompanyEmployee\Application\Queries\FindEmployeeQuery;
use Src\CompanyEmployee\Application\Queries\GetEmployeesQuery;
use Src\CompanyEmployee\Application\UseCases\Create\CreateEmployeeCompanyCommand;
use Src\CompanyEmployee\Application\UseCases\Delete\DeleteEmployeeCommand;
use Src\CompanyEmployee\Application\UseCases\Update\UpdateEmployeeCommand;
use Src\CompanyEmployee\Domain\Exceptions\EmployeeNotFound;
use Src\CompanyEmployee\UI\Http\Requests\CreateEmployeeRequest;
use Src\CompanyEmployee\UI\Http\Requests\UpdateEmployeeRequest;
use Src\CompanyEmployee\UI\Http\Resources\EmployeeResource;
use Src\CompanyEmployee\UI\Http\Resources\EmployeeResourceCollection;
use Src\Shared\Application\Bus\CommandHandlerInterface;

final class EmployeeController extends Controller
{
    public function __construct(private readonly CommandHandlerInterface $commandHandler) {}

    public function index(string $companyId, GetEmployeesQuery $query): EmployeeResourceCollection
    {
        return new EmployeeResourceCollection($query->get(new CompanyId($companyId)));
    }

    public function create(CreateEmployeeRequest $request, string $companyId): JsonResponse
    {
        $this->commandHandler->handle(
            new CreateEmployeeCompanyCommand(
                Uuid::uuid4()->toString(),
                $request->first_name,
                $request->last_name,
                $request->email,
                $request->phone,
                new CompanyId($companyId)
            )
        );

        return new JsonResponse([], JsonResponse::HTTP_CREATED);
    }

    public function get(string $companyId, string $id, FindEmployeeQuery $query): EmployeeResource
    {
        try {
            return new EmployeeResource($query->get($id));
        } catch (EmployeeNotFound $e) {
            abort(404, $e->getMessage());
        }
    }

    public function update(UpdateEmployeeRequest $request, string $companyId, string $id): JsonResponse
    {
        try {
            $this->commandHandler->handle(
                new UpdateEmployeeCommand(
                    $id,
                    $request->first_name,
                    $request->last_name,
                    $request->email,
                    $request->phone,
                )
            );

            return new JsonResponse([], JsonResponse::HTTP_OK);

        } catch (EmployeeNotFound $e) {
            abort(404, $e->getMessage());
        }
    }

    public function delete(string $companyId, string $id): JsonResponse
    {
        try {

            $this->commandHandler->handle(
                new DeleteEmployeeCommand(
                    $id,
                )
            );

            return new JsonResponse;

        } catch (EmployeeNotFound $e) {
            return new JsonResponse($e->getMessage(), JsonResponse::HTTP_NOT_FOUND);
        }
    }
}
