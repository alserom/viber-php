<?php

declare(strict_types=1);

namespace Alserom\Viber\Event\Type;

use Alserom\Viber\Entity\User;
use Alserom\Viber\Event\AbstractEvent;

/**
 * Class Webhook
 * @package Alserom\Viber\Event\Type
 * @author Alexander Romanov <contact@alserom.com>
 */
class Webhook extends AbstractEvent
{
    public const TYPE = 'webhook';

    /**
     * @inheritdoc
     */
    protected function getUserFromData(): User
    {
        return new User();
    }
}
