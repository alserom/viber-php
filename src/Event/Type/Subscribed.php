<?php

declare(strict_types=1);

namespace Alserom\Viber\Event\Type;

use Alserom\Viber\Entity\User;
use Alserom\Viber\Event\AbstractEvent;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class Subscribed
 * @package Alserom\Viber\Event\Type
 * @author Alexander Romanov <contact@alserom.com>
 */
class Subscribed extends AbstractEvent
{
    public const TYPE = 'subscribed';

    /**
     * @inheritdoc
     */
    protected function configureData(OptionsResolver $resolver): void
    {
        parent::configureData($resolver);

        $resolver->setRequired('user');
        $resolver->setAllowedTypes('user', 'array');
    }

    /**
     * @inheritdoc
     */
    protected function getUserFromData(): User
    {
        return User::fromArray($this->data['user']);
    }
}
