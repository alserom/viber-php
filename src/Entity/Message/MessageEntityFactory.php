<?php

declare(strict_types=1);

namespace Alserom\Viber\Entity\Message;

/**
 * Class MessageEntityFactory
 * @package Alserom\Viber\Entity\Message
 * @author Alexander Romanov <contact@alserom.com>
 */
final class MessageEntityFactory
{
    public const TYPE_CAROUSEL = 'carousel';
    public const TYPE_CONTACT = 'contact';
    public const TYPE_FILE = 'file';
    public const TYPE_KEYBOARD = 'keyboard';
    public const TYPE_LOCATION = 'location';
    public const TYPE_PICTURE = 'picture';
    public const TYPE_STICKER = 'sticker';
    public const TYPE_TEXT = 'text';
    public const TYPE_URL = 'url';
    public const TYPE_VIDEO = 'video';

    /**
     * @param string $class
     * @param array|null $data
     * @return MessageEntityInterface
     * @throws \InvalidArgumentException
     */
    public static function create(string $class, array $data = null): MessageEntityInterface
    {
        $type = strtolower($class);

        $types = [
            static::TYPE_CAROUSEL => Carousel::class,
            static::TYPE_CONTACT  => Contact::class,
            static::TYPE_FILE     => File::class,
            static::TYPE_KEYBOARD => Keyboard::class,
            static::TYPE_LOCATION => Location::class,
            static::TYPE_PICTURE  => Picture::class,
            static::TYPE_STICKER  => Sticker::class,
            static::TYPE_TEXT     => Text::class,
            static::TYPE_URL      => Url::class,
            static::TYPE_VIDEO    => Video::class
        ];

        if (\array_key_exists($type, $types)) {
            return $types[$type]::fromArray($data ?? []);
        }

        if (\in_array($class, $types, true)) {
            return $class::fromArray($data ?? []);
        }

        throw new \InvalidArgumentException('Invalid message type.');
    }
}
