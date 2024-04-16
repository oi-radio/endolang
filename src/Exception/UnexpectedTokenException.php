<?php

declare(strict_types=1);

namespace Yahiru\Endolang\Exception;

use Throwable;

final class UnexpectedTokenException extends \RuntimeException implements RuntimeException
{
    public function __construct(
        public readonly string $token,
        string $message = '',
        ?Throwable $previous = null,
    ) {
        parent::__construct($message, 0, $previous);
    }
}
