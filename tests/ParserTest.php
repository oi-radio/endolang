<?php

declare(strict_types=1);

namespace Yahiru\Endolang;

use PHPUnit\Framework\TestCase;
use Yahiru\Endolang\Exception\SyntaxException;
use Yahiru\Endolang\Node\DecrementPointer;
use Yahiru\Endolang\Node\DecrementValue;
use Yahiru\Endolang\Node\In;
use Yahiru\Endolang\Node\IncrementPointer;
use Yahiru\Endolang\Node\IncrementValue;
use Yahiru\Endolang\Node\Loop;
use Yahiru\Endolang\Node\Out;

use function assert;
use function get_class;

/**
 * @internal
 *
 * @small
 */
final class ParserTest extends TestCase
{
    private Parser $parser;

    protected function setUp(): void
    {
        parent::setUp();
        $this->parser = new Parser();
    }

    /**
     * @dataProvider parseDataProvider
     *
     * @param Node[] $expected
     */
    public function testParse(string $code, array $expected): void
    {
        $actual = $this->parser->parse($code);

        $this->assertNodes($expected, $actual);
    }

    /**
     * @return list<array{code:string, expected:Node[]}>
     */
    public static function parseDataProvider(): array
    {
        return [
            [
                'code' => 'えんどぅ〜結婚！',
                'expected' => [new IncrementPointer(), new DecrementPointer(), new IncrementValue(), new DecrementValue(), new Out(), new Loop([]), new In()],
            ],
            [
                'code' => '結！婚',
                'expected' => [new Loop([new In()])],
            ],
            [
                'code' => '結！結！婚！婚',
                'expected' => [
                    new Loop([
                        new In(),
                        new Loop([new In()]),
                        new In(),
                    ]),
                ],
            ],
        ];
    }

    /**
     * @dataProvider parseWithNoLoopStartDataProvider
     */
    public function testParseWithNoLoopStart(string $code): void
    {
        $this->expectException(SyntaxException::class);
        $this->expectExceptionMessage('ループの開始がありません。');

        $this->parser->parse($code);
    }

    /**
     * @return list<array{code:string}>
     */
    public static function parseWithNoLoopStartDataProvider(): array
    {
        return [
            ['code' => '婚'],
            ['code' => '結婚婚'],
        ];
    }

    /**
     * @dataProvider parseWithUnclosedLoopDataProvider
     */
    public function testParseWithUnclosedLoop(string $code): void
    {
        $this->expectException(SyntaxException::class);
        $this->expectExceptionMessage('ループの終了がありません。');

        $this->parser->parse($code);
    }

    /**
     * @return list<array{code:string}>
     */
    public static function parseWithUnclosedLoopDataProvider(): array
    {
        return [
            ['code' => '結'],
            ['code' => '結結婚'],
        ];
    }

    /**
     * @param list<Node> $expected
     * @param list<Node> $actual
     */
    private function assertNodes(array $expected, array $actual): void
    {
        $this->assertCount(count($expected), $actual);

        foreach ($expected as $i => $e) {
            $a = $actual[$i];

            $this->assertInstanceOf(get_class($e), $a);

            if ($e instanceof Loop) {
                assert($a instanceof Loop);
                $this->assertNodes($e->nodes, $a->nodes);
            }
        }
    }
}
