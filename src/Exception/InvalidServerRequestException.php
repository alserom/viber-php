<?php

declare(strict_types=1);

namespace Alserom\Viber\Exception;

use Psr\Http\Message\ServerRequestInterface;
use Throwable;

/**
 * Class InvalidServerRequestException
 * @package Alserom\Viber\Exception
 * @author Alexander Romanov <contact@alserom.com>
 */
class InvalidServerRequestException extends \RuntimeException
{
    private $request;

    /**
     * @param ServerRequestInterface $request
     * @param string $message
     * @param int $statusCode
     * @param Throwable|null $previous
     */
    public function __construct(
        ServerRequestInterface $request,
        string $message = '',
        int $statusCode = 500,
        Throwable $previous = null
    ) {
        $this->request = $request;

        parent::__construct($message, $statusCode, $previous);
    }

    /**
     * @return ServerRequestInterface
     */
    public function getRequest(): ServerRequestInterface
    {
        return $this->request;
    }
}
