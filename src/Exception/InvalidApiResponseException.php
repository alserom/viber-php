<?php

declare(strict_types=1);

namespace Alserom\Viber\Exception;

use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * Class InvalidApiResponseException
 * @package Alserom\Viber\Exception
 * @author Alexander Romanov <contact@alserom.com>
 */
class InvalidApiResponseException extends \RuntimeException
{
    private $httpResponse;

    /**
     * @param ResponseInterface $httpResponse
     * @param string $message
     * @param Throwable|null $previous
     */
    public function __construct(ResponseInterface $httpResponse, string $message = '', Throwable $previous = null)
    {
        $this->httpResponse = $httpResponse;
        $message = 'Invalid API response. ' . $message;

        parent::__construct($message, $httpResponse->getStatusCode(), $previous);
    }

    /**
     * @return ResponseInterface
     */
    public function getHttpResponse(): ResponseInterface
    {
        return $this->httpResponse;
    }
}
