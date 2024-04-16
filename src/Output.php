<?php

declare(strict_types=1);

namespace Yahiru\Endolang;

interface Output
{
    public function write(string $char): void;
}
