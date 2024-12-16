<?php

declare(strict_types=1);

namespace Src\Company\Application\Queries;

use Src\Company\Domain\Company;
use Src\Company\Domain\Finders\CompanyFinder;
use Src\Company\Domain\ValueObjects\CompanyId;

final readonly class FindCompanyQuery
{
    public function __construct(private CompanyFinder $finder) {}

    public function get(string $id): Company
    {
        return $this->finder->find(new CompanyId($id));
    }
}
