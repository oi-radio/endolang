<?php

declare(strict_types=1);

namespace Yahiru\Endolang;

use Yahiru\Endolang\Exception\InvalidInputException;
use Yahiru\Endolang\Exception\PointerUnderflowException;
use Yahiru\Endolang\Exception\UnexpectedNodeException;
use Yahiru\Endolang\Node\Loop;

use function mb_chr;
use function mb_ord;

final class Endolang
{
    private int $position = 0;
    /** @var array<int, int> */
    private array $addresses = [];

    public function __construct(
        private readonly Input $input,
        private readonly Output $output,
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
        } elseif ($node instanceof Node\Out) {
            $value = $this->getValue();
            $char = mb_chr($value);

            if (! is_string($char)) {
                throw new InvalidInputException((string) $value);
            }

            $this->output->write($char);
        } elseif ($node instanceof Node\DecrementPointer) {
            $this->decrementPointer();
        } elseif ($node instanceof Node\IncrementValue) {
            $this->setValue($this->getValue() + 1);
        } elseif ($node instanceof Node\DecrementValue) {
            $this->setValue($this->getValue() - 1);
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

    private function decrementPointer(): void
    {
        if (0 === $this->position) {
            throw new PointerUnderflowException();
        }

        $this->position--;
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
