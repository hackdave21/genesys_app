<?php

namespace App\Exceptions;

use Exception;

class ClaudeApiException extends Exception
{
    public function __construct(
        string $message = 'Erreur lors de l\'appel à l\'API Claude.',
        int $code = 0,
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
