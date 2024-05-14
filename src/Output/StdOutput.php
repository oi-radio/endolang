<?php

declare(strict_types=1);

namespace OiRadio\Endolang\Output;

use OiRadio\Endolang\Output;

final class StdOutput implements Output
{
    public function write(string $char): void
    {
        echo $char;
    }
}
