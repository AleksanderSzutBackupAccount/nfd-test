<?php

declare(strict_types=1);

namespace Src\Shared\Application\Bus;

use Src\Shared\Domain\Bus\CommandInterface;
use Illuminate\Contracts\Bus\Dispatcher;

class DBTransactionCommandHandler implements DBTransactionCommandHandlerInterface
{
    private Dispatcher $dispatcher;

    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function handle(CommandInterface $commands): void
    {
        $this->dispatcher
            ->pipeThrough([
                UseDatabaseTransactions::class,
            ])
            ->dispatch($commands);
    }
}
