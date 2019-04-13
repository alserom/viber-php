<?php

namespace Alserom\Viber\Request;

use Alserom\Viber\Exception\InvalidApiRequestException;
use Alserom\Viber\Exception\MissingDependencyException;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriFactoryInterface;
use Psr\Http\Message\UriInterface;

/**
 * Interface ApiRequestInterface
 * @package Alserom\Viber\Request
 * @author Alexander Romanov <contact@alserom.com>
 */
interface ApiRequestInterface
{
    public const BASE_URL = 'https://chatapi.viber.com/pa/';

    public const AUTH_HEADER_NAME = 'X-Viber-Auth-Token';

    /**
     * @param UriFactoryInterface $uriFactory
     * @return ApiRequestInterface
     */
    public function setUriFactory(UriFactoryInterface $uriFactory): self;

    /**
     * @param StreamFactoryInterface $streamFactory
     * @return ApiRequestInterface
     */
    public function setStreamFactory(StreamFactoryInterface $streamFactory): self;

    /**
     * @param RequestFactoryInterface $requestFactory
     * @return ApiRequestInterface
     */
    public function setRequestFactory(RequestFactoryInterface $requestFactory): self;

    /**
     * @return UriInterface
     * @throws MissingDependencyException
     */
    public function getResourceUrl(): UriInterface;

    /**
     * @return string
     */
    public function getApiMethod(): string;

    /**
     * @return StreamInterface
     * @throws MissingDependencyException
     */
    public function getBody(): StreamInterface;

    /**
     * @return RequestInterface
     * @throws MissingDependencyException
     */
    public function getHttpRequest(): RequestInterface;

    /**
     * @return string
     */
    public function getHash(): string;

    /**
     * @throws InvalidApiRequestException
     */
    public function validate(): void;
}
