<?php

declare(strict_types=1);

namespace Yahiru\Endolang;

use PHPUnit\Framework\TestCase;
use Throwable;
use Yahiru\Endolang\Input\InMemoryInput;
use Yahiru\Endolang\Output\InMemoryOutput;

/**
 * @internal
 *
 * @small
 */
final class EndolangTest extends TestCase
{
    private InMemoryInput $input;
    private InMemoryOutput $output;
    private Endolang $endo;

    protected function setUp(): void
    {
        parent::setUp();

        $this->input = new InMemoryInput();
        $this->output = new InMemoryOutput();
        $this->endo = new Endolang($this->input, $this->output);
    }

    /**
     * @dataProvider runDataProvider
     */
    public function testRun(string $code, string $expected): void
    {
        $this->endo->run($code);

        $this->assertSame($expected, $this->output->getOutput());
    }

    /**
     * @return list<array{code:string, expected:string}>
     */
    public static function runDataProvider(): array
    {
        return [
            [
                'code' => '〜',
                'expected' => "\x00",
            ],
            [
                'code' => 'どどどど〜',
                'expected' => "\x04",
            ],
        ];
    }

    /**
     * @dataProvider runWithExceptionDataProvider
     *
     * @param array{class:class-string<Throwable>, message?:string} $expected
     */
    public function testRunWithException(string $code, array $expected): void
    {
        $this->expectException($expected['class']);

        if (isset($expected['message'])) {
            $this->expectExceptionMessage($expected['message']);
        }

        $this->endo->run($code);
    }

    /**
     * @return list<array{code:string, expected: array{class:class-string<Throwable>, message?:string}}>
     */
    public static function runWithExceptionDataProvider(): array
    {
        return [
            [
                'code' => 'ぅ〜',
                'expected' => [
                    'class' => Exception\InvalidInputException::class,
                ],
            ],
            [
                'code' => 'ん',
                'expected' => [
                    'class' => Exception\PointerUnderflowException::class,
                ],
            ],
        ];
    }
}
