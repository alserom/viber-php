<?php

declare(strict_types=1);

namespace Alserom\Viber\Entity\Message;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Picture
 * @package Alserom\Viber\Entity\Message
 * @author Alexander Romanov <contact@alserom.com>
 */
class Picture extends AbstractMessage
{
    public const TYPE = 'picture';

    protected $text;

    protected $media;

    protected $thumbnail;

    protected $fileName;

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
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * @param string $text
     * @return Picture
     */
    public function setText(string $text): self
    {
        $this->text = $text;

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
     * @param string $media
     * @return Picture
     */
    public function setMedia(string $media): self
    {
        $this->media = $media;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getThumbnail(): ?string
    {
        return $this->thumbnail;
    }

    /**
     * @param string|null $thumbnail
     * @return Picture
     */
    public function setThumbnail(string $thumbnail = null): self
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    /**
     * @param string $fileName
     * @return Picture
     */
    public function setFileName(string $fileName): self
    {
        $this->fileName = $fileName;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata): void
    {
        $metadata->addPropertyConstraints('text', [
            new Assert\Length(['max' => 120])
        ]);
        $metadata->addPropertyConstraints('media', [
            new Assert\NotBlank(),
            new Assert\Url(),
            // @TODO: Max size 1 MB. Only JPEG format is supported.
        ]);
        // @TODO: Validate rules for other properties

        parent::loadValidatorMetadata($metadata);
    }
}
