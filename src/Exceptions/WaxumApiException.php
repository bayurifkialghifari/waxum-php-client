<?php

namespace Bayurifkialghifari\WaxumApi\Exceptions;

use Exception;

class WaxumApiException extends Exception
{
    public function __construct(
        string $message,
        int $code = 0,
        public readonly mixed $details = null,
    ) {
        parent::__construct($message, $code);
    }
}
