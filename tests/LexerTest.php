<?php

declare(strict_types=1);

namespace Yahiru\Endolang;

use PHPUnit\Framework\TestCase;
use Yahiru\Endolang\Exception\UnexpectedTokenException;

/**
 * @internal
 *
 * @small
 */
final class LexerTest extends TestCase
{
    public function testNext(): void
    {
        $lexer = new Lexer('');

        // 末尾に達したらnullを返す
        $this->assertNull($lexer->next());
    }

    public function testNextWithUnexpectedToken(): void
    {
        $lexer = new Lexer('離婚！');

        $this->expectException(UnexpectedTokenException::class);
        $lexer->next();
    }

    public function testIgnoreSpaces(): void
    {
        $lexer = new Lexer("\n \t");

        $this->assertNull($lexer->next());
    }
}
