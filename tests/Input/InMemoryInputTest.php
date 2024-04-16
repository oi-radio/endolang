<?php

declare(strict_types=1);

namespace Yahiru\Endolang\Input;

use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @small
 */
final class InMemoryInputTest extends TestCase
{
    public InMemoryInput $input;

    protected function setUp(): void
    {
        parent::setUp();
        $this->input = new InMemoryInput();
    }

    public function testRead(): void
    {
        $this->input->add('a');
        $this->input->add('あ');
        $this->input->add('かきく');

        $this->assertSame('a', $this->input->read());
        $this->assertSame('あ', $this->input->read());

        // 最初の一文字だけ返す
        $this->assertSame('か', $this->input->read());

        // 入力がない場合は空文字を返す
        $this->assertSame('', $this->input->read());
    }
}
