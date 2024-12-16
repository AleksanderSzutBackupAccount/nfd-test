<?php

declare(strict_types=1);

namespace Src\Company\Application\UseCases\Delete;

use Src\Shared\Domain\Bus\CommandInterface;

final readonly class DeleteCompanyCommand implements CommandInterface
{
    public function __construct(
        public string $id,
    ) {}
}
