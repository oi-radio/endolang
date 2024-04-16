<?php

declare(strict_types=1);

namespace Yahiru\Endolang\Output;

use Yahiru\Endolang\Output;

final class StdOutput implements Output
{
    public function write(string $char): void
    {
        echo $char;
    }
}
