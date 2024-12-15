<?php

declare(strict_types=1);

namespace Src\Company\Application\Create;

use Src\Shared\Domain\Bus\CommandInterface;

final readonly class CreateCompanyCommand implements CommandInterface
{
    public function __construct(
        public string $id,
        public string $name,
        public string $nip,
        public string $city,
        public string $postalCode,
        public string $address,
    ) {}
}
