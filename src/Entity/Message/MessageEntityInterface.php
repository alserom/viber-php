<?php

namespace Alserom\Viber\Entity\Message;

use Alserom\Viber\Entity\EntityInterface;
use Alserom\Viber\Entity\Keyboard;

/**
 * Interface MessageEntityInterface
 * @package Alserom\Viber\Entity\Message
 * @author Alexander Romanov <contact@alserom.com>
 */
interface MessageEntityInterface extends EntityInterface
{
    /**
     * @return string
     */
    public function getType(): string;

    /**
     * @return string|null
     */
    public function getTrackingData(): ?string;

    /**
     * @return Keyboard|null
     */
    public function getKeyboard(): ?Keyboard;
}
