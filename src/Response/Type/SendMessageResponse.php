<?php

declare(strict_types=1);

namespace Alserom\Viber\Response\Type;

use Alserom\Viber\Exception\InvalidApiResponseException;
use Alserom\Viber\Response\AbstractApiResponse;

/**
 * Class SendMessageResponse
 * @package Alserom\Viber\Response\Type
 * @author Alexander Romanov <contact@alserom.com>
 */
class SendMessageResponse extends AbstractApiResponse
{
    private $messageToken;

    /**
     * @return string
     */
    public function getMessageToken(): string
    {
        return (string) $this->messageToken;
    }

    /**
     * @inheritdoc
     */
    protected function populateEntities(): void
    {
        $messageToken = $this->data['message_token'] ?? null;
        if ($messageToken === null) {
            throw new InvalidApiResponseException($this->httpResponse, '"message_token" property missing');
        }

        $this->messageToken = $messageToken;
    }
}
