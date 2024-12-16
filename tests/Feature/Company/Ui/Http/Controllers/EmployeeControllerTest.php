<?php

declare(strict_types=1);

namespace Feature\Company\Ui\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Src\Company\Infrastructure\Eloquent\Models\CompanyEloquentModel;
use Src\CompanyEmployee\Infrastructure\Eloquent\Models\EmployeeEloquentModel;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

final class EmployeeControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private const JSON_STRUCTURE = ['id', 'first_name', 'last_name', 'email', 'phone'];

    public function test_create_success(): void
    {
        $payload = $this->getPayload();

        $company = $this->companyFactory();
        $response = $this->post($this->getEndpoint($company->id), $payload);
        $response->assertStatus(JsonResponse::HTTP_CREATED);

        $this->assertDatabaseCount('employees', 1);
        $this->assertDatabaseHas('employees', $payload);
    }

    public function test_index_success(): void
    {
        $count = 5;

        $company = $this->companyFactory();
        $this->employeeFactoryMany($count, $company);

        $response = $this->get($this->getEndpoint($company->id));
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure(['*' => self::JSON_STRUCTURE]);
        $response->assertJsonCount($count);
    }

    public function test_get_success(): void
    {
        $company = $this->companyFactory();
        $employee = $this->employeeFactory($company);

        $response = $this->get($this->getEndpointFind($company->id, $employee->id));
        $response->assertStatus(JsonResponse::HTTP_OK);
        $response->assertJsonStructure(self::JSON_STRUCTURE);
    }

    public function test_update_success(): void
    {
        $company = $this->companyFactory();
        $employee = $this->employeeFactory($company);

        $payload = $this->getPayload();
        $response = $this->put($this->getEndpointFind($company->id, $employee->id), $payload);
        $response->assertStatus(JsonResponse::HTTP_OK);
        $this->assertDatabaseHas('employees', $payload);
    }

    public function test_delete_success(): void
    {
        $company = $this->companyFactory();
        $employee = $this->employeeFactory($company);
        $response = $this->delete($this->getEndpointFind($company->id, $employee->id), $this->getPayload());
        $response->assertStatus(JsonResponse::HTTP_OK);
        $this->assertDatabaseCount('employees', 0);
    }

    private function getEndpoint(string $companyId): string
    {
        return sprintf('api/companies/%s/employees', $companyId);
    }

    private function getEndpointFind(string $companyId, string $employeeId): string
    {
        return sprintf('api/companies/%s/employees/%s', $companyId, $employeeId);
    }

    private function companyFactory(): CompanyEloquentModel
    {
        /** @var CompanyEloquentModel $company */
        $company = CompanyEloquentModel::factory()->create();

        return $company;
    }

    private function employeeFactory(CompanyEloquentModel $company): EmployeeEloquentModel
    {
        /** @var EmployeeEloquentModel $employee */
        $employee = EmployeeEloquentModel::factory(['company_id' => $company])->create();

        return $employee;
    }

    private function employeeFactoryMany(int $count, CompanyEloquentModel $company): Collection
    {
        return EmployeeEloquentModel::factory(['company_id' => $company])->count($count)->create();
    }

    /**
     * @return string[]
     */
    private function getPayload(): array
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
        ];
    }
}
