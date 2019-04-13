<?php

declare(strict_types=1);

namespace Alserom\Viber\Entity\Message;

/**
 * Class Keyboard
 * @package Alserom\Viber\Entity\Message
 * @author Alexander Romanov <contact@alserom.com>
 */
class Keyboard extends AbstractMessage
{
    public const TYPE = 'keyboard';

    /**
     * @inheritdoc
     */
    public function getType(): string
    {
        return self::TYPE;
    }
}
