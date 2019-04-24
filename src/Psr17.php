<?php

declare(strict_types=1);

namespace Alserom\Viber;

use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UploadedFileFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;

/**
 * Class Psr17
 * @package Alserom\Viber
 * @author Alexander Romanov <contact@alserom.com>
 */
final class Psr17
{
    private $requestFactory;
    private $responseFactory;
    private $serverRequestFactory;
    private $streamFactory;
    private $uploadedFileFactory;
    private $uriFactory;

    /**
     * @param RequestFactoryInterface $requestFactory
     * @param ResponseFactoryInterface $responseFactory
     * @param ServerRequestFactoryInterface $serverRequestFactory
     * @param StreamFactoryInterface $streamFactory
     * @param UploadedFileFactoryInterface $uploadedFileFactory
     * @param UriFactoryInterface $uriFactory
     */
    public function __construct(
        RequestFactoryInterface $requestFactory,
        ResponseFactoryInterface $responseFactory,
        ServerRequestFactoryInterface $serverRequestFactory,
        StreamFactoryInterface $streamFactory,
        UploadedFileFactoryInterface $uploadedFileFactory,
        UriFactoryInterface $uriFactory
    ) {
        $this->requestFactory = $requestFactory;
        $this->responseFactory = $responseFactory;
        $this->serverRequestFactory = $serverRequestFactory;
        $this->streamFactory = $streamFactory;
        $this->uploadedFileFactory = $uploadedFileFactory;
        $this->uriFactory = $uriFactory;
    }

    /**
     * @param mixed $psr17Factory Must implements all PSR-17 interfaces
     * @return Psr17
     * @throws \InvalidArgumentException
     */
    public static function useForAll($psr17Factory): self
    {
        $missedInterface = [];
        if (!$psr17Factory instanceof RequestFactoryInterface) {
            $missedInterface[] = RequestFactoryInterface::class;
        }
        if (!$psr17Factory instanceof ResponseFactoryInterface) {
            $missedInterface[] = ResponseFactoryInterface::class;
        }
        if (!$psr17Factory instanceof ServerRequestFactoryInterface) {
            $missedInterface[] = ServerRequestFactoryInterface::class;
        }
        if (!$psr17Factory instanceof StreamFactoryInterface) {
            $missedInterface[] = StreamFactoryInterface::class;
        }
        if (!$psr17Factory instanceof UploadedFileFactoryInterface) {
            $missedInterface[] = UploadedFileFactoryInterface::class;
        }
        if (!$psr17Factory instanceof UriFactoryInterface) {
            $missedInterface[] = UriFactoryInterface::class;
        }

        if (\count($missedInterface) !== 0) {
            throw new \InvalidArgumentException(sprintf(
                'The passed argument does not realise the required interfaces: %s',
                implode(', ', $missedInterface)
            ));
        }

        return new self($psr17Factory, $psr17Factory, $psr17Factory, $psr17Factory, $psr17Factory, $psr17Factory);
    }

    /**
     * @return RequestFactoryInterface
     */
    public function getRequestFactory(): RequestFactoryInterface
    {
        return $this->requestFactory;
    }

    /**
     * @return ResponseFactoryInterface
     */
    public function getResponseFactory(): ResponseFactoryInterface
    {
        return $this->responseFactory;
    }

    /**
     * @return ServerRequestFactoryInterface
     */
    public function getServerRequestFactory(): ServerRequestFactoryInterface
    {
        return $this->serverRequestFactory;
    }

    /**
     * @return StreamFactoryInterface
     */
    public function getStreamFactory(): StreamFactoryInterface
    {
        return $this->streamFactory;
    }

    /**
     * @return UploadedFileFactoryInterface
     */
    public function getUploadedFileFactory(): UploadedFileFactoryInterface
    {
        return $this->uploadedFileFactory;
    }

    /**
     * @return UriFactoryInterface
     */
    public function getUriFactory(): UriFactoryInterface
    {
        return $this->uriFactory;
    }
}
