<?php

declare(strict_types=1);

namespace Src\CompanyEmployee\Infrastructure\Eloquent\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Src\CompanyEmployee\Infrastructure\Eloquent\Models\EmployeeEloquentModel;

/**
 * @extends Factory<EmployeeEloquentModel>
 */
final class EmployeeEloquentFactory extends Factory
{
    protected $model = EmployeeEloquentModel::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
        ];
    }
}
