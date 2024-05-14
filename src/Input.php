<?php

declare(strict_types=1);

namespace OiRadio\Endolang;

interface Input
{
    public function read(): string;
}
