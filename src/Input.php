<?php

declare(strict_types=1);

namespace Yahiru\Endolang;

interface Input
{
    public function read(): string;
}
