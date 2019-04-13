<?php

declare(strict_types=1);

namespace Alserom\Viber\Request\Type;

use Alserom\Viber\Request\AbstractApiRequest;

/**
 * Class RemoveWebhook
 * @package Alserom\Viber\Request\Type
 * @author Alexander Romanov <contact@alserom.com>
 */
class RemoveWebhook extends AbstractApiRequest
{
    public const API_METHOD = 'set_webhook';

    /**
     * @inheritdoc
     */
    public function getApiMethod(): string
    {
        return self::API_METHOD;
    }

    /**
     * @inheritdoc
     */
    public function getBodyData(): string
    {
        return (string) json_encode(['url' => '']);
    }
}
