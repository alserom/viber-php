<?php

declare(strict_types=1);

namespace Alserom\Viber\Event\Type;

use Alserom\Viber\Entity\Message\MessageEntityFactory;
use Alserom\Viber\Entity\Message\MessageEntityInterface;
use Alserom\Viber\Entity\User;
use Alserom\Viber\Event\AbstractEvent;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class Message
 * @package Alserom\Viber\Event\Type
 * @author Alexander Romanov <contact@alserom.com>
 */
class Message extends AbstractEvent
{
    public const TYPE = 'message';

    protected const AVAILABLE_MESSAGE_TYPES = [
        'contact',
        'file',
        'location',
        'picture',
        'sticker',
        'text',
        'url',
        'video'
    ];

    protected $message;

    /**
     * @inheritdoc
     */
    protected function configureData(OptionsResolver $resolver): void
    {
        parent::configureData($resolver);

        $resolver->setRequired([
            'sender',
            'message'
        ]);
        $resolver->setAllowedTypes('sender', 'array');
        $resolver->setAllowedTypes('message', 'array');
        $resolver->setDefault('message', function (OptionsResolver $spoolResolver) {
            $spoolResolver->setRequired('type');
            $spoolResolver->setAllowedTypes('type', 'string');
            $spoolResolver->setAllowedValues('type', static::AVAILABLE_MESSAGE_TYPES);
            $spoolResolver->setDefined([
                'text',
                'media',
                'location',
                'contact',
                'tracking_data',
                'file_name',
                'file_size',
                'duration',
                'sticker_id',
                'size',
                'thumbnail'
            ]);
        });
    }

    /**
     * @inheritdoc
     * @throws \InvalidArgumentException
     */
    protected function populateProperties(): void
    {
        parent::populateProperties();

        $this->message = MessageEntityFactory::create($this->data['message']['type'], $this->data['message']);
    }

    /**
     * @inheritdoc
     */
    protected function getUserFromData(): User
    {
        return User::fromArray($this->data['sender']);
    }

    /**
     * @return MessageEntityInterface
     */
    public function getMessage(): MessageEntityInterface
    {
        return $this->message;
    }
}
