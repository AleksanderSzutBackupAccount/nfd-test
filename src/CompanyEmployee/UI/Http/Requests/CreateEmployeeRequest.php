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
final class CreateEmployeeRequest extends FormRequest
{
    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:employees',
            'phone' => 'nullable|string',
        ];
    }
}
