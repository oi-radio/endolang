<?php

declare(strict_types=1);

namespace Yahiru\Endolang;

use Yahiru\Endolang\Exception\InvalidInputException;
use Yahiru\Endolang\Exception\UnexpectedNodeException;

use function mb_ord;

final class Endolang
{
    public function __construct(
        private readonly Input $input,
    ) {
    }

    public function run(string $code): void
    {
        $nodes = (new Parser())->parse($code);
        /** @var int[] $addresses */
        $addresses = [];
        $position = 0;

        foreach ($nodes as $node) {
            if ($node instanceof Node\In) {
                $char = $this->input->read();
                $codePoint = mb_ord($char);

                if (! is_int($codePoint)) {
                    throw new InvalidInputException($char);
                }

                $addresses[$position] = $codePoint;
            } else {
                throw new UnexpectedNodeException($node);
            }
        }
    }
}
