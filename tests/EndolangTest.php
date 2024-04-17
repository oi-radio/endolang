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
            [
                'code' => 'どどどど〜えどど〜',
                'expected' => "\x04\x02",
            ],
            [
                'code' => 'どどえどどど〜ん〜',
                'expected' => "\x03\x02",
            ],
            [
                'code' => 'えどどどどどどどど結んどどどどどどどどどえぅ婚ん〜えどどどど結んどどどどどどどえぅ婚んど〜どどどどどどど〜〜どどど〜ええどどどどどど結んどどどどどどどえぅ婚んどど〜ぅぅぅぅぅぅぅぅぅぅぅぅ〜えどどどどどど結んどどどどどどどどどえぅ婚んど〜ん〜どどど〜ぅぅぅぅぅぅ〜ぅぅぅぅぅぅぅぅ〜えええどどどど結んどどどどどどどどえぅ婚んど〜',
                'expected' => 'Hello, World!',
            ],
            [
                'code' => 'どどどどどどどどどど'
                        .'結'
                            .'ぅ' // 10回回す
                            .'え' // loopの最後に2つ目のアドレスまで戻るためのマーカー
                            .'えどどどどどどど' // C 67
                            .'えどどどどどどどどどどど' // o 111
                            .'えどどどどどどどどどどど' // n 110
                            .'えどどどどどどどどどど' // g 103
                            .'えどどどどどどどどどどど' // r 114
                            .'えどどどどどどどどどど' // a 97
                            .'えどどどどどどどどどどど' // t 116
                            .'えどどどどどどどどどどど' // u 117
                            .'えどどどどどどどどどどど' // l 108
                            .'えどどどどどどどどどど' // a 97
                            .'えどどどどどどどどどどど' // t 116
                            .'えどどどどどどどどどど' // i 105
                            .'えどどどどどどどどどどど' // o 111
                            .'えどどどどどどどどどどど' // n 110
                            .'えどどどどどどどどどどど' // s 115
                            .'えどどど' //[ 32
                            .'えどどどどどどどどどどど' // o 111
                            .'えどどどどどどどどどどど' // n 110
                            .'えどどど' //[ 32
                            .'えどどどどどどどどどどどど' // y 121
                            .'えどどどどどどどどどどど' // o 111
                            .'えどどどどどどどどどどどど' // u 117
                            .'えどどどどどどどどどどど' // r 114
                            .'えどどど' //[ 32
                            .'えどどどどどどどどどどどど' // w 119
                            .'えどどどどどどどどどど' // e 101
                            .'えどどどどどどどどどど' // d 100
                            .'えどどどどどどどどどど' // d 100
                            .'えどどどどどどどどどど' // i 105
                            .'えどどどどどどどどどどど' // n 110
                            .'えどどどどどどどどどど' // g 103
                            .'えどどど' // ! 33
                            .'結ん婚' // 文字数分ポインタを戻す
                            .'ん' // ポインタを先頭に戻す
                        .'婚'
                        .'ええ' // 文字列の始まりまでポインタを移動
                        .'ぅぅぅ〜' // C
                        .'えど〜' // o
                        .'え〜' // n
                        .'えどどど〜' // g
                        .'えどどどど〜' // r
                        .'えぅぅぅ〜' // a
                        .'えどどどどどど〜' // t
                        .'えどどどどどどど〜' // u
                        .'えぅぅ〜' // l
                        .'えぅぅぅ〜' // a
                        .'えどどどどどど〜' // t
                        .'えどどどどど〜' // i
                        .'えど〜' // o
                        .'え〜' // n
                        .'えどどどどど〜' // s
                        .'えどど〜' //[
                        .'えど〜' // o
                        .'え〜' // n
                        .'えどど〜' //[
                        .'えど〜' // y
                        .'えど〜' // o
                        .'えぅぅぅ〜' // u
                        .'えどどどど〜' // r
                        .'えどど〜' //[
                        .'えぅ〜' // w
                        .'えど〜' // e
                        .'え〜' // d
                        .'え〜' // d
                        .'えどどどどど〜' // i
                        .'え〜' // n
                        .'えどどど〜' // g
                        .'えどどど〜' //[!
                ,
                'expected' => 'Congratulations on your wedding!',
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
