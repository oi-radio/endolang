<?php

declare(strict_types=1);

namespace Yahiru\Endolang;

use Yahiru\Endolang\Exception\InvalidInputException;
use Yahiru\Endolang\Exception\UnexpectedNodeException;
use Yahiru\Endolang\Node\Loop;

use function mb_ord;

final class Endolang
{
    private int $position = 0;
    /** @var array<int, int> */
    private array $addresses = [];

    public function __construct(
        private readonly Input $input,
    ) {
    }

    public function run(string $code): void
    {
        $this->addresses = [];
        $this->position = 0;
        $nodes = (new Parser())->parse($code);

        foreach ($nodes as $node) {
            $this->handleNode($node);
        }
    }

    private function handleNode(Node $node): void
    {
        if ($node instanceof Node\In) {
            $char = $this->input->read();
            $codePoint = mb_ord($char);

            if (! is_int($codePoint)) {
                throw new InvalidInputException($char);
            }

            $this->setValue($codePoint);
        } elseif ($node instanceof Loop) {
            while ($this->getValue()) {
                foreach ($node->nodes as $innerNode) {
                    $this->handleNode($innerNode);
                }
            }
        } else {
            throw new UnexpectedNodeException($node);
        }
    }

    private function getValue(): int
    {
        return $this->addresses[$this->position] ?? 0;
    }

    private function setValue(int $value): void
    {
        $this->addresses[$this->position] = $value;
    }
}
