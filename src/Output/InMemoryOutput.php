<?php

declare(strict_types=1);

namespace Yahiru\Endolang\Output;

use Yahiru\Endolang\Output;

final class InMemoryOutput implements Output
{
    private string $output = '';

    public function write(string $char): void
    {
        $this->output .= $char;
    }

    public function getOutput(): string
    {
        return $this->output;
    }
}
