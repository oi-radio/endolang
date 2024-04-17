<?php

declare(strict_types=1);

namespace Yahiru\Endolang;

use Yahiru\Endolang\Exception\SyntaxException;
use Yahiru\Endolang\Exception\UnexpectedTokenException;
use Yahiru\Endolang\Node\Loop;

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
            $nodes[] = $this->handleToken($token, $lexer);
        }

        return $nodes;
    }

    private function handleToken(Token $token, Lexer $lexer): Node
    {
        return match ($token) {
            Token::IncrementPointer => new Node\IncrementPointer(),
            Token::DecrementPointer => new Node\DecrementPointer(),
            Token::IncrementValue => new Node\IncrementValue(),
            Token::DecrementValue => new Node\DecrementValue(),
            Token::In => new Node\In(),
            Token::Out => new Node\Out(),
            Token::LoopStart => $this->doParseLoop($lexer),
            // LoopEnd は構文が正しい場合は doParseLoop で処理されるため、ここに LoopEnd が来るのはプログラムのバグか構文エラーのみ.
            Token::LoopEnd => throw new SyntaxException('ループの開始がありません。'),
        };
    }

    private function doParseLoop(Lexer $lexer): Loop
    {
        $nodes = [];

        while ($token = $lexer->next()) {
            if (Token::LoopEnd === $token) {
                return new Loop($nodes);
            }

            $nodes[] = $this->handleToken($token, $lexer);
        }

        throw new SyntaxException('ループの終了がありません。');
    }
}
