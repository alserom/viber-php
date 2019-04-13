<?php

declare(strict_types=1);

namespace Alserom\Viber\Event\Type;

use Alserom\Viber\Entity\User;
use Alserom\Viber\Event\AbstractEvent;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class Delivered
 * @package Alserom\Viber\Event\Type
 * @author Alexander Romanov <contact@alserom.com>
 */
class Delivered extends AbstractEvent
{
    public const TYPE = 'delivered';

    /**
     * @inheritdoc
     */
    protected function configureData(OptionsResolver $resolver): void
    {
        parent::configureData($resolver);

        $resolver->setRequired('user_id');
        $resolver->setAllowedTypes('user_id', 'string');
    }

    /**
     * @inheritdoc
     */
    protected function getUserFromData(): User
    {
        return new User($this->data['user_id']);
    }
}
