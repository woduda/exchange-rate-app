<?php

declare(strict_types=1);

namespace Infrastructure\Shared\Bus\Command;

use Application\Command;
use Application\CommandBus;
use Symfony\Component\Messenger\MessageBusInterface;

final class MessageCommandBus implements CommandBus
{
    private MessageBusInterface $commandBus;

    public function __construct(MessageBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function dispatch(Command $command): void
    {
        $this->commandBus->dispatch($command);
    }
}
