<?php

declare(strict_types=1);

namespace Alserom\Viber\Entity\Message;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Sticker
 * @package Alserom\Viber\Entity\Message
 * @author Alexander Romanov <contact@alserom.com>
 */
class Sticker extends AbstractMessage
{
    public const TYPE = 'sticker';

    protected $stickerId;

    protected $media;

    /**
     * @inheritdoc
     */
    public function getType(): string
    {
        return self::TYPE;
    }

    /**
     * @return int|null
     */
    public function getStickerId(): ?int
    {
        return $this->stickerId;
    }

    /**
     * @param int $stickerId
     * @return Sticker
     */
    public function setStickerId(int $stickerId): self
    {
        $this->stickerId = $stickerId;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getMedia(): ?string
    {
        return $this->media;
    }

    /**
     * @param string|null $media
     * @return Sticker
     */
    public function setMedia(string $media = null): self
    {
        $this->media = $media;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata): void
    {
        $metadata->addPropertyConstraint('stickerId', new Assert\NotBlank());
        $metadata->addPropertyConstraint('media', new Assert\Url());

        parent::loadValidatorMetadata($metadata);
    }
}
