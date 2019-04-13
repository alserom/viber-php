<?php

declare(strict_types=1);

namespace Alserom\Viber\Event\Type;

use Alserom\Viber\Entity\User;
use Alserom\Viber\Event\AbstractEvent;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ConversationStarted
 * @package Alserom\Viber\Event\Type
 * @author Alexander Romanov <contact@alserom.com>
 */
class ConversationStarted extends AbstractEvent
{
    public const TYPE = 'conversation_started';

    protected $type;

    protected $context;

    protected $subscribed;

    /**
     * @inheritdoc
     */
    protected function configureData(OptionsResolver $resolver): void
    {
        parent::configureData($resolver);

        $resolver->setDefault('context', '');
        $resolver->setRequired([
            'type',
            'context',
            'subscribed',
            'user'
        ]);
        $resolver->setAllowedTypes('type', 'string');
        $resolver->setAllowedTypes('context', 'string');
        $resolver->setAllowedTypes('subscribed', 'bool');
        $resolver->setAllowedTypes('user', 'array');
    }

    /**
     * @inheritdoc
     */
    protected function populateProperties(): void
    {
        parent::populateProperties();

        $this->type = $this->data['type'];
        $this->context = $this->data['context'];
        $this->subscribed = $this->data['subscribed'];
    }

    /**
     * @inheritdoc
     */
    protected function getUserFromData(): User
    {
        return User::fromArray($this->data['user']);
    }
}
