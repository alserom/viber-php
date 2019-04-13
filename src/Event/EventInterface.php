<?php

namespace Alserom\Viber\Event;

use Alserom\Viber\Entity\User;
use Alserom\Viber\Exception\InvalidEventException;

/**
 * Interface EventInterface
 * @package Alserom\Viber\Event
 * @author Alexander Romanov <contact@alserom.com>
 */
interface EventInterface
{
    public const AVAILABLE_EVENTS = [
        'delivered',
        'seen',
        'failed',
        'subscribed',
        'unsubscribed',
        'conversation_started',
        'message',
        'webhook',
        'action'
    ];

    /**
     * @param array $data
     * @throws InvalidEventException
     */
    public function __construct(array $data);

    /**
     * @return string
     */
    public function getEventType(): string;

    /**
     * @return array
     */
    public function getData(): array;

    /**
     * @return int
     */
    public function getTimestamp(): int;

    /**
     * @return string
     */
    public function getMessageToken(): string;

    /**
     * @return User
     */
    public function getUser(): User;

    /**
     * @return string|null
     */
    public function getChatHostname(): ?string;
}
