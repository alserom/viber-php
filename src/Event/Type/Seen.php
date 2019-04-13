<?php

declare(strict_types=1);

namespace Alserom\Viber\Event\Type;

/**
 * Class Seen
 * @package Alserom\Viber\Event\Type
 * @author Alexander Romanov <contact@alserom.com>
 */
class Seen extends Delivered
{
    public const TYPE = 'seen';
}
