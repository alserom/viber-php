<?php

declare(strict_types=1);

namespace Alserom\Viber\Entity\Message;

use Alserom\Viber\Validator\Constraints\ValidEntity;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;
use Alserom\Viber\Entity\Location as LocationEntity;

/**
 * Class Location
 * @package Alserom\Viber\Entity\Message
 * @author Alexander Romanov <contact@alserom.com>
 */
class Location extends AbstractMessage
{
    public const TYPE = 'location';

    protected $location;

    /**
     * @inheritdoc
     */
    public function getType(): string
    {
        return self::TYPE;
    }

    /**
     * @return LocationEntity|null
     */
    public function getLocation(): ?LocationEntity
    {
        return $this->location;
    }

    /**
     * @param LocationEntity $location
     * @return Location
     */
    public function setLocation(LocationEntity $location): self
    {
        $this->location = $location;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata): void
    {
        $metadata->addPropertyConstraints('location', [
            new Assert\NotNull(),
            new ValidEntity()
        ]);

        parent::loadValidatorMetadata($metadata);
    }
}
