<?php

declare(strict_types=1);

namespace Yahiru\Endolang;

use Yahiru\Endolang\Exception\UnexpectedTokenException;

final class Parser
{
    /**
     * @throws UnexpectedTokenException
     *
     * @return list<Node>
     */
    public function parse(string $code): array
    {
        $lexer = new Lexer($code);

        $nodes = [];

        while ($token = $lexer->next()) {
            $nodes[] = match ($token) {
                Token::In => new Node\In(),
            };
        }

        return $nodes;
    }
}
