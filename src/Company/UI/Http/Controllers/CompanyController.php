<?php

declare(strict_types=1);

namespace Src\Company\UI\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

final class CompanyController extends Controller
{
    public function index(): JsonResponse
    {
        return new JsonResponse([]);
    }

    public function get(int $companyId): JsonResponse
    {
        return new JsonResponse([]);
    }

    public function update(int $companyId): JsonResponse
    {
        return new JsonResponse([]);
    }

    public function delete(int $companyId): JsonResponse
    {
        return new JsonResponse([]);
    }

    public function create(): JsonResponse
    {
        return new JsonResponse([]);
    }
}
