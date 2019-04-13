<?php

declare(strict_types=1);

namespace Alserom\Viber\Request;

use Alserom\Viber\Entity\EntityInterface;
use Alserom\Viber\Exception\InvalidApiRequestException;
use Alserom\Viber\Exception\InvalidEntityException;
use Alserom\Viber\Exception\MissingDependencyException;
use Alserom\Viber\Validator\EntityValidator;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriFactoryInterface;
use Psr\Http\Message\UriInterface;

/**
 * Class AbstractApiRequest
 * @package Alserom\Viber\Request
 * @author Alexander Romanov <contact@alserom.com>
 */
abstract class AbstractApiRequest implements ApiRequestInterface
{
    protected $uriFactory;

    protected $streamFactory;

    protected $requestFactory;

    protected $token;

    protected $httpRequest;

    private $entitiesToValidate = [];

    /**
     * @param string $token
     */
    public function __construct(string $token)
    {
        $this->token = $token;
    }

    /**
     * @inheritdoc
     */
    public function setUriFactory(UriFactoryInterface $uriFactory): ApiRequestInterface
    {
        $this->uriFactory = $uriFactory;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setStreamFactory(StreamFactoryInterface $streamFactory): ApiRequestInterface
    {
        $this->streamFactory = $streamFactory;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setRequestFactory(RequestFactoryInterface $requestFactory): ApiRequestInterface
    {
        $this->requestFactory = $requestFactory;

        return $this;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @inheritdoc
     */
    public function getResourceUrl(): UriInterface
    {
        if (!$this->uriFactory instanceof UriFactoryInterface) {
            throw new MissingDependencyException(
                sprintf('UriFactory was missing. Use %s::setUriFactory for set it.', __CLASS__)
            );
        }

        return $this->uriFactory->createUri(self::BASE_URL . $this->getApiMethod());
    }

    /**
     * @return string
     */
    abstract protected function getBodyData(): string;

    /**
     * @inheritdoc
     */
    public function getBody(): StreamInterface
    {
        if (!$this->streamFactory instanceof StreamFactoryInterface) {
            throw new MissingDependencyException(
                sprintf('StreamFactory was missing. Use %s::setStreamFactory for set it.', __CLASS__)
            );
        }

        return $this->streamFactory->createStream($this->getBodyData());
    }

    /**
     * @inheritdoc
     */
    public function getHttpRequest(): RequestInterface
    {
        if (!$this->requestFactory instanceof RequestFactoryInterface) {
            throw new MissingDependencyException(
                sprintf('RequestFactory was missing. Use %s::setRequestFactory for set it.', __CLASS__)
            );
        }

        if (!$this->httpRequest instanceof RequestInterface) {
            $this->httpRequest = $this->requestFactory->createRequest($this->getHttpMethod(), $this->getResourceUrl());
            foreach ($this->getHeaders() as $name => $value) {
                $this->httpRequest = $this->httpRequest->withHeader($name, $value);
            }
            $this->httpRequest = $this->httpRequest->withBody($this->getBody());
        }

        return $this->httpRequest;
    }

    /**
     * @inheritdoc
     */
    public function getHash(): string
    {
        return md5($this->token . $this->getApiMethod() . $this->getBodyData());
    }

    /**
     * @inheritdoc
     */
    public function validate(): void
    {
        try {
            $this->validateEntities();
            $this->validateBody();
        } catch (InvalidApiRequestException $ex) {
            throw $ex;
        } catch (\Exception $ex) {
            throw new InvalidApiRequestException($ex->getMessage(), 0, $ex);
        }
    }

    /**
     * @return string
     */
    protected function getHttpMethod(): string
    {
        return 'POST';
    }

    /**
     * @param array $data
     * @return array
     */
    protected function filterData(array $data): array
    {
        foreach ($data as $key => $value) {
            if (\is_array($value)) {
                $data[$key] = $this->filterData($value);
            }

            if ($data[$key] === null || $data[$key] === []) {
                unset($data[$key]);
            }
        }

        return $data;
    }

    /**
     * @throws InvalidApiRequestException
     */
    protected function validateBody(): void
    {
        $size = (int) $this->getBody()->getSize();

        /**
         * Viber note: Maximum total JSON size of the request is 30kb.
         */
        if ($size > 30000) {
            throw new InvalidApiRequestException(
                sprintf(
                    'Body size is too large. Maximum total JSON size of the request is 30kb and you have %s bytes.',
                    $size
                )
            );
        }
    }

    /**
     * @param EntityInterface $entity
     */
    protected function addEntityToValidate(EntityInterface $entity): void
    {
        $this->entitiesToValidate[] = $entity;
    }

    /**
     * @throws InvalidEntityException
     */
    protected function validateEntities(): void
    {
        foreach ($this->entitiesToValidate as $entity) {
            if (!$entity instanceof EntityInterface) {
                continue;
            }

            $this->validateEntity($entity);
        }
    }

    /**
     * @param EntityInterface $entity
     * @throws InvalidEntityException
     */
    protected function validateEntity(EntityInterface $entity): void
    {
        EntityValidator::validate($entity);
    }

    /**
     * @return array
     */
    protected function getHeaders(): array
    {
        return [
            self::AUTH_HEADER_NAME => $this->getToken(),
            'Content-Type'         => 'application/json'
        ];
    }
}
