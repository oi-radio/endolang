<?php

declare(strict_types=1);

namespace OiRadio\Endolang\Output;

use OiRadio\Endolang\Output;

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
