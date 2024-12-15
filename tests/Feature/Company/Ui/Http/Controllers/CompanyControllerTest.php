<?php

declare(strict_types=1);

namespace Feature\Company\Ui\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Src\Company\Infrastructure\Eloquent\CompanyEloquentModel;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

final class CompanyControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private const JSON_STRUCTURE = ['id', 'name', 'address', 'city', 'postal_code'];

    public function test_create_success(): void
    {
        $payload = $this->getPayload();
        $payload['nip'] = $this->faker->uuid;

        $response = $this->post('api/companies', $payload);
        $response->assertStatus(JsonResponse::HTTP_CREATED);

        $this->assertDatabaseCount('companies', 1);
        $this->assertDatabaseHas('companies', $payload);
    }

    public function test_index_success(): void
    {
        $count = 5;
        $this->companyFactoryMany($count);

        $response = $this->get('api/companies');
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure(['*' => self::JSON_STRUCTURE]);
        $response->assertJsonCount($count);
    }

    public function test_get_success(): void
    {
        $companyEloquentModel = $this->companyFactory();

        $response = $this->get($this->getEndpoint($companyEloquentModel->id));
        $response->assertStatus(JsonResponse::HTTP_OK);
        $response->assertJsonStructure(self::JSON_STRUCTURE);
    }

    public function test_update_success(): void
    {
        $companyEloquentModel = $this->companyFactory();

        $payload = $this->getPayload();
        $response = $this->put($this->getEndpoint($companyEloquentModel->id), $payload);
        $response->assertStatus(JsonResponse::HTTP_OK);
        $this->assertDatabaseHas('companies', $payload);
    }

    public function test_delete_success(): void
    {
        $companyEloquentModel = $this->companyFactory();
        $response = $this->delete($this->getEndpoint($companyEloquentModel->id), $this->getPayload());
        $response->assertStatus(JsonResponse::HTTP_OK);
        $this->assertDatabaseCount('companies', 0);
    }

    public function getEndpoint(int $companyId): string
    {
        return sprintf('api/companies/%s', $companyId);
    }

    public function companyFactory(): CompanyEloquentModel
    {
        /** @var CompanyEloquentModel $companyEloquentModel */
        $companyEloquentModel = CompanyEloquentModel::factory()->create();

        return $companyEloquentModel;
    }

    public function companyFactoryMany(int $count): Collection
    {
        return CompanyEloquentModel::factory()->count($count)->create();
    }

    /**
     * @return string[]
     */
    public function getPayload(): array
    {
        return [
            'name' => $this->faker->company,
            'address' => $this->faker->address,
            'city' => $this->faker->city,
            'postal_code' => $this->faker->postcode,
        ];
    }
}
