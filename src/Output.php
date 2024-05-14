<?php

declare(strict_types=1);

namespace OiRadio\Endolang;

interface Output
{
    public function write(string $char): void;
}
