<?php

declare(strict_types=1);

namespace OiRadio\Endolang\Output;

use PHPUnit\Framework\TestCase;

use function ob_end_clean;
use function ob_get_contents;
use function ob_start;

/**
 * @internal
 *
 * @small
 */
final class StdOutputTest extends TestCase
{
    private StdOutput $output;

    protected function setUp(): void
    {
        parent::setUp();
        $this->output = new StdOutput();
        ob_start();
    }

    protected function tearDown(): void
    {
        ob_end_clean();
        parent::tearDown();
    }

    public function testWrite(): void
    {
        $this->output->write('a');
        $this->assertSame('a', ob_get_contents());

        $this->output->write('b');
        $this->assertSame('ab', ob_get_contents());
    }
}
