<?php

declare(strict_types=1);

namespace Application;

interface CommandBus
{
    public function dispatch(Command $command): void;

}
