<?php

declare(strict_types=1);

namespace OiRadio\Endolang\Exception;

use Throwable;

final class InvalidInputException extends \RuntimeException implements RuntimeException
{
    public function __construct(
        public readonly string $char,
        string $message = '',
        ?Throwable $previous = null
    ) {
        parent::__construct($message, 0, $previous);
    }
}
