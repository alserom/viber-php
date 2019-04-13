<?php

declare(strict_types=1);

namespace Alserom\Viber\Exception;

use Throwable;

/**
 * Class InvalidEventHandlerException
 * @package Alserom\Viber\Exception
 * @author Alexander Romanov <contact@alserom.com>
 */
class InvalidEventHandlerException extends \RuntimeException
{
    /**
     * @param Throwable $previous
     */
    public function __construct(Throwable $previous)
    {
        $message = sprintf(
            'Invalid event handler. See previous exception. %s: %s',
            \get_class($previous),
            $previous->getMessage()
        );

        parent::__construct($message, 0, $previous);
    }
}
