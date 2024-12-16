<?php

declare(strict_types=1);

namespace Src\Company\UI\Http\Resources;

use Illuminate\Http\Request;
use Src\Company\Domain\Collections\Companies;
use Src\Company\Domain\Company;
use Src\Shared\UI\Http\Resources\AbstractJsonResource;

final readonly class CompanyResourceCollection extends AbstractJsonResource
{
    public function __construct(private Companies $companies) {}

    public function toArray(Request $request): array
    {
        return $this->companies->map(
            fn (Company $company) => (new CompanyResource($company))
        );

    }
}
