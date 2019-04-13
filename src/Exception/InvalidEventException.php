<?php

declare(strict_types=1);

namespace Alserom\Viber\Exception;

use Throwable;

/**
 * Class InvalidEventException
 * @package Alserom\Viber\Exception
 * @author Alexander Romanov <contact@alserom.com>
 */
class InvalidEventException extends \RuntimeException
{
    protected $data;

    /**
     * @param string $message
     * @param array $data
     * @param Throwable|null $previous
     */
    public function __construct(string $message = '', array $data = [], Throwable $previous = null)
    {
        $this->data = $data;
        $message = 'Invalid event. ' . $message;

        parent::__construct($message, 0, $previous);
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }
}
