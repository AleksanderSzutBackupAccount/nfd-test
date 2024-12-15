<?php

declare(strict_types=1);

namespace Src\Company\Infrastructure\Eloquent;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CompanyEloquentModel>
 */
final class CompanyEloquentFactory extends Factory
{
    protected $model = CompanyEloquentModel::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company,
            'address' => $this->faker->address,
            'city' => $this->faker->city,
            'postal_code' => $this->faker->postcode,
            'nip' => $this->faker->unique()->randomNumber(9),
        ];
    }
}
