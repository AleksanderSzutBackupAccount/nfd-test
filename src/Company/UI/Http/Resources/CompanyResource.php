<?php

declare(strict_types=1);

namespace Src\Company\UI\Http\Resources;

use Illuminate\Http\Request;
use Src\Company\Domain\Company;
use Src\Shared\UI\Http\Resources\AbstractJsonResource;

final readonly class CompanyResource extends AbstractJsonResource
{
    public function __construct(private Company $company) {}

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->company->id,
            'name' => $this->company->name,
            'nip' => $this->company->companyNip,
            'address' => $this->company->address->address,
            'postal_code' => $this->company->address->postalCode,
            'city' => $this->company->address->city,
        ];
    }
}
