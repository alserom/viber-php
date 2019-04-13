<?php

declare(strict_types=1);

namespace Alserom\Viber\Entity\Message;

use Alserom\Viber\Entity\AbstractEntity;
use Alserom\Viber\Entity\Keyboard;
use Alserom\Viber\Validator\Constraints\ValidEntity;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class AbstractMessage
 * @package Alserom\Viber\Entity\Message
 * @author Alexander Romanov <contact@alserom.com>
 */
abstract class AbstractMessage extends AbstractEntity implements MessageEntityInterface
{
    protected $trackingData;

    protected $keyboard;

    /**
     * @inheritdoc
     */
    public function getTrackingData(): ?string
    {
        return $this->trackingData;
    }

    /**
     * @param string|null $trackingData
     * @return $this
     */
    public function setTrackingData(string $trackingData = null): self
    {
        $this->trackingData = $trackingData;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getKeyboard(): ?Keyboard
    {
        return $this->keyboard;
    }

    /**
     * @param Keyboard|null $keyboard
     * @return $this
     */
    public function setKeyboard(Keyboard $keyboard = null): self
    {
        $this->keyboard = $keyboard;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata): void
    {
        $metadata->addPropertyConstraint('trackingData', new Assert\Length(['max' => 4000]));
        $metadata->addPropertyConstraint('keyboard', new ValidEntity());
    }
}
