<?php

declare(strict_types=1);

namespace Alserom\Viber\Exception;

use Throwable;

/**
 * Class InvalidApiRequestException
 * @package Alserom\Viber\Exception
 * @author Alexander Romanov <contact@alserom.com>
 */
class InvalidApiRequestException extends \RuntimeException
{
    /**
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $message = '', int $code = 0, Throwable $previous = null)
    {
        $message = 'Invalid API request. ' . $message;

        parent::__construct($message, $code, $previous);
    }
}
