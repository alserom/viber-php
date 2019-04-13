<?php

declare(strict_types=1);

namespace Alserom\Viber\Event;

use Alserom\Viber\Event\Type;
use Alserom\Viber\Exception\InvalidEventException;

/**
 * Class EventFactory
 * @package Alserom\Viber\Event
 * @author Alexander Romanov <contact@alserom.com>
 */
final class EventFactory
{
    /**
     * @param array $data
     * @return EventInterface
     * @throws InvalidEventException
     */
    public static function create(array $data): EventInterface
    {
        $type = $data['event'] ?? null;

        $types = [
            Type\ConversationStarted::TYPE => Type\ConversationStarted::class,
            Type\Delivered::TYPE           => Type\Delivered::class,
            Type\Failed::TYPE              => Type\Failed::class,
            Type\Message::TYPE             => Type\Message::class,
            Type\Seen::TYPE                => Type\Seen::class,
            Type\Subscribed::TYPE          => Type\Subscribed::class,
            Type\Unsubscribed::TYPE        => Type\Unsubscribed::class,
            Type\Webhook::TYPE             => Type\Webhook::class
        ];

        if (\array_key_exists($type, $types)) {
            return new $types[$type]($data);
        }

        throw new InvalidEventException('Invalid/Unknown event type.', $data);
    }
}
