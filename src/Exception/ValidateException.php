<?php

namespace App\Exception;

use RuntimeException;

class ValidateException extends RuntimeException
{
    public function __construct(
        private array $errors = [],
        string $message = 'Validation failed',
        int $code = 422,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
