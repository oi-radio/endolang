<?php

declare(strict_types=1);

namespace Yahiru\Endolang;

use Yahiru\Endolang\Exception\UnexpectedTokenException;

use function in_array;
use function mb_str_split;

final class Lexer
{
    private int $position = 0;

    /** @var list<string> */
    private readonly array $chars;

    public function __construct(
        string $code
    ) {
        $this->chars = mb_str_split($code);
    }

    /**
     * @throws UnexpectedTokenException
     */
    public function next(): ?Token
    {
        while (isset($this->chars[$this->position])) {
            $char = $this->chars[$this->position];

            if (in_array($char, [' ', "\n", "\t"], true)) {
                $this->position++;

                continue;
            }

            break;
        }

        if (! isset($this->chars[$this->position])) {
            return null;
        }

        $char = $this->chars[$this->position];
        $this->position++;

        $token = Token::tryFrom($char);

        if (null === $token) {
            throw new UnexpectedTokenException($char);
        }

        return $token;
    }
}
