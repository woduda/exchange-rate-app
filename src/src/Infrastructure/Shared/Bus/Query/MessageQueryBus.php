<?php

declare(strict_types=1);

namespace Infrastructure\Shared\Bus\Query;

use Application\Query;
use Application\QueryBus;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

final class MessageQueryBus implements QueryBus
{
    use HandleTrait {
        handle as handleQuery;
    }

    public function __construct(MessageBusInterface $queryBus)
    {
        $this->messageBus = $queryBus;
    }

    /** @return mixed */
    public function handle(Query $query)
    {
        return $this->handleQuery($query);
    }
}
