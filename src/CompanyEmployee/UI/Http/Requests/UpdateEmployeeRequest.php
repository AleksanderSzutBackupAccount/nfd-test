<?php

declare(strict_types=1);

namespace Src\CompanyEmployee\UI\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read string $first_name
 * @property-read string $last_name
 * @property-read string $email
 * @property-read string $phone
 */
final class UpdateEmployeeRequest extends FormRequest
{
    /**
     * @return string[]
     */
    public function rules(): array
    {
        /** @var string $employeeId */
        $employeeId = $this->route('id');

        return [
            'first_name' => 'string',
            'last_name' => 'string',
            'email' => 'email|unique:employees,email,'.$employeeId,
            'phone' => 'nullable|string',
        ];
    }
}
