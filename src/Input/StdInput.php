<?php

declare(strict_types=1);

namespace Yahiru\Endolang\Input;

use Yahiru\Endolang\Input;

use function fgets;
use function mb_str_split;

final class StdInput implements Input
{
    public function read(): string
    {
        $read = fgets(STDIN);

        if (false === $read) {
            return '';
        }

        return mb_str_split($read)[0] ?? '';
    }
}
