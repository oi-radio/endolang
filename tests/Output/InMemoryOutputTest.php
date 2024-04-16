<?php

declare(strict_types=1);

namespace Yahiru\Endolang\Output;

use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @small
 */
final class InMemoryOutputTest extends TestCase
{
    private InMemoryOutput $output;

    protected function setUp(): void
    {
        parent::setUp();
        $this->output = new InMemoryOutput();
    }

    public function testWrite(): void
    {
        $this->assertSame('', $this->output->getOutput());

        $this->output->write('a');
        $this->assertSame('a', $this->output->getOutput());

        $this->output->write('b');
        $this->assertSame('ab', $this->output->getOutput());
    }
}
