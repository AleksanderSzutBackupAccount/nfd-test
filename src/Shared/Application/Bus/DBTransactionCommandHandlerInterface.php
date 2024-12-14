<?php

declare(strict_types=1);

namespace Src\Shared\Application\Bus;

use Src\Shared\Domain\Bus\CommandInterface;

interface DBTransactionCommandHandlerInterface
{
    /**
     * @param CommandInterface $commands
     * @return void
     */
    public function handle(CommandInterface $commands): void;
}
