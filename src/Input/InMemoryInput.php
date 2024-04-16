<?php

declare(strict_types=1);

namespace Yahiru\Endolang\Input;

use Yahiru\Endolang\Input;

use function mb_str_split;

final class InMemoryInput implements Input
{
    private int $position = 0;

    /**
     * @param list<string> $inputs
     */
    public function __construct(
        private array $inputs = [],
    ) {
    }

    public function add(string $input): void
    {
        $this->inputs[] = $input;
    }

    public function read(): string
    {
        $str = $this->inputs[$this->position++] ?? '';

        return mb_str_split($str)[0] ?? '';
    }
}
