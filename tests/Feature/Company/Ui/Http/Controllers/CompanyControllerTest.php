<?php

declare(strict_types=1);

namespace Feature\Company\Ui\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Tests\TestCase;

final class CompanyControllerTest extends TestCase
{
   private const JSON_STRUCTURE = ['id', 'name', 'email', 'address', 'city', 'postcode'];

    public function testCreateSuccess(): void {
        $response = $this->post('api/companies', [
            'name' => 'Test Company',
            'email' => 'test@test.com',
            'address' => 'Test Address',
            'city' => 'Test City',
            'postcode' => 'Test Postcode',
        ]);
        $response->assertStatus(JsonResponse::HTTP_CREATED);
    }

    public function testIndexSuccess(): void {
        $response = $this->get('api/companies');
        $response->assertStatus(JsonResponse::HTTP_OK);
        $response->assertJsonStructure(['*' => self::JSON_STRUCTURE]);
    }

    public function testGetSuccess(): void {
        $companyId = 1;

        $response = $this->get($this->getEndpoint($companyId));
        $response->assertStatus(JsonResponse::HTTP_OK);
        $response->assertJsonStructure(self::JSON_STRUCTURE);
    }

    public function testUpdateSuccess(): void {
        $companyId = 1;

        $response = $this->put($this->getEndpoint($companyId));
        $response->assertStatus(JsonResponse::HTTP_OK);
    }
    public function testDeleteSuccess(): void {
        $companyId = 1;

        $response = $this->put($this->getEndpoint($companyId));
        $response->assertStatus(JsonResponse::HTTP_OK);
    }

    public function getEndpoint(int $companyId): string
    {
        return sprintf('api/companies/%s', $companyId);
    }


}
