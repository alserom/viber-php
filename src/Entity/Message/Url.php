<?php

declare(strict_types=1);

namespace Alserom\Viber\Entity\Message;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Url
 * @package Alserom\Viber\Entity\Message
 * @author Alexander Romanov <contact@alserom.com>
 */
class Url extends AbstractMessage
{
    public const TYPE = 'url';

    protected $media;

    /**
     * @inheritdoc
     */
    public function getType(): string
    {
        return self::TYPE;
    }

    /**
     * @return string|null
     */
    public function getMedia(): ?string
    {
        return $this->media;
    }

    /**
     * @param string $media
     * @return Url
     */
    public function setMedia(string $media): self
    {
        $this->media = $media;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata): void
    {
        $metadata->addPropertyConstraints('media', [
            new Assert\NotBlank(),
            new Assert\Url(),
            new Assert\Length(['max' => 2000])
        ]);

        parent::loadValidatorMetadata($metadata);
    }
}
