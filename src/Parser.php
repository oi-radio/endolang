<?php

declare(strict_types=1);

namespace Yahiru\Endolang;

use Exception;
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
            throw new Exception('Not implemented yet');
        }

        return $nodes;
    }
}