<?php

declare(strict_types=1);

namespace Alserom\Viber\Entity;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Map
 * @package Alserom\Viber\Entity
 * @author Alexander Romanov <contact@alserom.com>
 */
class Map extends AbstractEntity
{
    protected const KEYS_CASE = 'pascal';

    protected $latitude;

    protected $longitude;

    /**
     * @return float|null
     */
    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    /**
     * @param float|null $latitude
     * @return Map
     */
    public function setLatitude(float $latitude = null): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    /**
     * @param float|null $longitude
     * @return Map
     */
    public function setLongitude(float $longitude = null): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata): void
    {
        // @TODO: Validate rules for other properties
    }
}
