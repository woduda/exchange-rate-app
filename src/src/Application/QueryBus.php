<?php

declare(strict_types=1);

namespace Application;

interface QueryBus
{
    /** @return mixed */
    public function handle(Query $query);
}
