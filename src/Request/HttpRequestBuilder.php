<?php

declare(strict_types=1);

namespace Alserom\Viber\Request;

use Alserom\Viber\Exception\InvalidApiRequestException;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;

/**
 * Class ApiRequestFactory
 * @package Alserom\Viber\Request
 * @author Alexander Romanov <contact@alserom.com>
 */
class HttpRequestBuilder
{
    private $requestFactory;

    private $streamFactory;

    private $uriFactory;

    private $validateRequest;

    /**
     * @param RequestFactoryInterface $requestFactory
     * @param StreamFactoryInterface $streamFactory
     * @param UriFactoryInterface $uriFactory
     * @param bool $validateRequest
     */
    public function __construct(
        RequestFactoryInterface $requestFactory,
        StreamFactoryInterface $streamFactory,
        UriFactoryInterface $uriFactory,
        bool $validateRequest
    ) {
        $this->requestFactory = $requestFactory;
        $this->streamFactory = $streamFactory;
        $this->uriFactory = $uriFactory;
        $this->validateRequest = $validateRequest;
    }

    /**
     * @param ApiRequestInterface $apiRequest
     * @return RequestInterface
     * @throws InvalidApiRequestException
     */
    public function build(ApiRequestInterface $apiRequest): RequestInterface
    {
        $apiRequest
            ->setRequestFactory($this->requestFactory)
            ->setStreamFactory($this->streamFactory)
            ->setUriFactory($this->uriFactory);

        if ($this->validateRequest) {
            $apiRequest->validate();
        }

        return $apiRequest->getHttpRequest();
    }
}
