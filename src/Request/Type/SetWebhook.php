<?php

declare(strict_types=1);

namespace Alserom\Viber\Request\Type;

use Alserom\Viber\Entity\Webhook;
use Alserom\Viber\Request\AbstractApiRequest;

/**
 * Class SetWebhook
 * @package Alserom\Viber\Request\Type
 * @author Alexander Romanov <contact@alserom.com>
 */
class SetWebhook extends AbstractApiRequest
{
    public const API_METHOD = 'set_webhook';

    private $webhook;

    /**
     * @param string $token
     * @param Webhook $webhook
     */
    public function __construct(string $token, Webhook $webhook)
    {
        parent::__construct($token);

        $this->webhook = $webhook;
        $this->addEntityToValidate($webhook);
    }

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
        $data = $this->webhook->toArray();
        $data = $this->filterData($data);

        return (string) json_encode($data);
    }
}
