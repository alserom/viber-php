<?php

declare(strict_types=1);

namespace Alserom\Viber\Entity\Message;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class File
 * @package Alserom\Viber\Entity\Message
 * @author Alexander Romanov <contact@alserom.com>
 */
class File extends AbstractMessage
{
    public const TYPE = 'file';

    protected $media;

    protected $size;

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
    public function getMedia(): ?string
    {
        return $this->media;
    }

    /**
     * @param string $media
     * @return File
     */
    public function setMedia(string $media): self
    {
        $this->media = $media;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getSize(): ?int
    {
        return $this->size;
    }

    /**
     * @param int $size
     * @return File
     */
    public function setSize(int $size): self
    {
        $this->size = $size;

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
     * @return File
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
        $metadata->addPropertyConstraints('media', [
            new Assert\NotBlank(),
            new Assert\Url(),
            // @TODO: Max size 50 MB. forbidden file formats
        ]);
        $metadata->addPropertyConstraint('size', new Assert\NotBlank());
        $metadata->addPropertyConstraints('fileName', [
            new Assert\NotBlank(),
            new Assert\Length(['max' => 256])
        ]);

        parent::loadValidatorMetadata($metadata);
    }
}
