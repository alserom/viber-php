<?php

declare(strict_types=1);

namespace Alserom\Viber\Response\Type;

use Alserom\Viber\Exception\InvalidApiResponseException;
use Alserom\Viber\Response\AbstractApiResponse;

/**
 * Class SetWebhookResponse
 * @package Alserom\Viber\Response\Type
 * @author Alexander Romanov <contact@alserom.com>
 */
class SetWebhookResponse extends AbstractApiResponse
{
    /**
     * @return array
     */
    public function getEventTypes(): array
    {
        return (array) $this->data['event_types'];
    }

    /**
     * @inheritdoc
     */
    protected function populateEntities(): void
    {
        if (!\array_key_exists('event_types', $this->data)) {
            throw new InvalidApiResponseException($this->httpResponse, '"event_types" property missing');
        }
    }
}
