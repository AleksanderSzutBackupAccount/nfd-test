<?php

declare(strict_types=1);

namespace Src\Shared\Application\Bus;

use Src\Shared\Domain\Bus\CommandInterface;
use Illuminate\Contracts\Bus\Dispatcher;

class CommandHandler implements CommandHandlerInterface
{
    private Dispatcher $dispatcher;

    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function handle(CommandInterface $command): void
    {
        $this->dispatcher->dispatch($command);
    }
}
