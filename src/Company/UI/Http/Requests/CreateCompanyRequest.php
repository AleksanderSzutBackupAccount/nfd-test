<?php

declare(strict_types=1);

namespace Src\Company\UI\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read string $name
 * @property-read string $nip
 * @property-read string $address
 * @property-read string $city
 * @property-read string $postal_code
 */
final class CreateCompanyRequest extends FormRequest
{
    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'nip' => 'required|string|unique:companies',
            'address' => 'required|string',
            'city' => 'required|string',
            'postal_code' => 'required|string',
        ];
    }
}
