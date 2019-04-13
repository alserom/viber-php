<?php

declare(strict_types=1);

namespace Alserom\Viber\Response;

use Alserom\Viber\Entity\EntityInterface;
use Alserom\Viber\Exception\InvalidApiRequestException;
use Alserom\Viber\Exception\InvalidApiResponseException;
use Psr\Http\Message\ResponseInterface;

/**
 * Class AbstractApiResponse
 * @package Alserom\Viber\Response
 * @author Alexander Romanov <contact@alserom.com>
 */
abstract class AbstractApiResponse implements ApiResponseInterface
{
    protected $httpResponse;

    protected $chatHostname;

    protected $data = [];

    /**
     * @param ResponseInterface $httpResponse
     * @throws InvalidApiResponseException|InvalidApiRequestException
     */
    public function __construct(ResponseInterface $httpResponse)
    {
        $this->httpResponse = $httpResponse;

        $this->init();
    }

    /**
     * @inheritdoc
     */
    public function __toString(): string
    {
        return (string) json_encode($this->data);
    }

    /**
     * @throws InvalidApiResponseException
     */
    abstract protected function populateEntities(): void;

    /**
     * @param EntityInterface $entity
     * @param array $data
     */
    protected function populateEntity(EntityInterface $entity, array $data): void
    {
        foreach ($data as $prop => $value) {
            $setter = 'set' . str_replace('_', '', ucwords($prop, '_'));
            if (method_exists($entity, $setter)) {
                $entity->$setter($value);
            }
        }
    }

    /**
     * @throws InvalidApiResponseException|InvalidApiRequestException
     */
    private function init(): void
    {
        $data = (array) json_decode($this->httpResponse->getBody()->__toString(), true, 512, JSON_BIGINT_AS_STRING);

        $jsonError = json_last_error();
        if ($jsonError !== JSON_ERROR_NONE) {
            $msg = self::JSON_ERRORS[$jsonError] ?? 'Unknown';
            throw new InvalidApiResponseException($this->httpResponse, sprintf('JSON decoding error: %s.', $msg));
        }

        if (!\array_key_exists('status', $data) || !\array_key_exists('status_message', $data)) {
            throw new InvalidApiResponseException(
                $this->httpResponse,
                '"status" or "status_message" property missing.'
            );
        }

        $status = $data['status'];
        if ($status !== 0) {
            throw new InvalidApiRequestException((string) $data['status_message'], (int) $status);
        }

        $this->chatHostname = $data['chat_hostname'] ?? '';
        $this->data = $data;
        try {
            $this->populateEntities();
        } catch (InvalidApiResponseException $ex) {
            throw $ex;
        } catch (\Exception $ex) {
            throw new InvalidApiResponseException($this->httpResponse, $ex->getMessage(), $ex);
        }
    }

    /**
     * @inheritdoc
     */
    public function getHttpResponse(): ResponseInterface
    {
        return $this->httpResponse;
    }

    /**
     * @inheritdoc
     */
    public function getChatHostname(): ?string
    {
        return $this->chatHostname;
    }

    /**
     * @inheritdoc
     */
    public function getData(): array
    {
        return $this->data;
    }
}
