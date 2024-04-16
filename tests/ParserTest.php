<?php

declare(strict_types=1);

namespace Yahiru\Endolang;

use PHPUnit\Framework\TestCase;
use Yahiru\Endolang\Node\In;

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
                'code' => '！',
                'expected' => [new In()],
            ],
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
        }
    }
}
