<?php

declare(strict_types=1);

namespace Yahiru\Endolang\Exception;

use Throwable;
use Yahiru\Endolang\Node;

final class UnexpectedNodeException extends \RuntimeException implements RuntimeException
{
    public function __construct(
        public readonly Node $node,
        string $message = '',
        ?Throwable $previous = null,
    ) {
        parent::__construct($message, 0, $previous);
    }
}
