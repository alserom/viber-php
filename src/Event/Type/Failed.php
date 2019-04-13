<?php

declare(strict_types=1);

namespace Alserom\Viber\Event\Type;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class Failed
 * @package Alserom\Viber\Event\Type
 * @author Alexander Romanov <contact@alserom.com>
 */
class Failed extends Delivered
{
    public const TYPE = 'failed';

    protected $desc;

    /**
     * @inheritdoc
     */
    protected function configureData(OptionsResolver $resolver): void
    {
        parent::configureData($resolver);

        $resolver->setRequired('desc');
        $resolver->setAllowedTypes('desc', 'string');
    }

    /**
     * @inheritdoc
     */
    protected function populateProperties(): void
    {
        parent::populateProperties();

        $this->desc = $this->data['desc'];
    }

    /**
     * @return string
     */
    public function getDesc(): string
    {
        return $this->desc;
    }
}
