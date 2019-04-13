<?php

declare(strict_types=1);

namespace Alserom\Viber\Event\Type;

/**
 * Class Unsubscribed
 * @package Alserom\Viber\Event\Type
 * @author Alexander Romanov <contact@alserom.com>
 */
class Unsubscribed extends Delivered
{
    public const TYPE = 'unsubscribed';
}
