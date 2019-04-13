<?php

declare(strict_types=1);

namespace Alserom\Viber\Entity;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class MediaPlayer
 * @package Alserom\Viber\Entity
 * @author Alexander Romanov <contact@alserom.com>
 */
class MediaPlayer extends AbstractEntity
{
    protected const KEYS_CASE = 'pascal';

    protected $title;

    protected $subtitle;

    protected $thumbnailURL;

    protected $loop;

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     * @return MediaPlayer
     */
    public function setTitle(string $title = null): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSubtitle(): ?string
    {
        return $this->subtitle;
    }

    /**
     * @param string|null $subtitle
     * @return MediaPlayer
     */
    public function setSubtitle(string $subtitle = null): self
    {
        $this->subtitle = $subtitle;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getThumbnailURL(): ?string
    {
        return $this->thumbnailURL;
    }

    /**
     * @param string|null $thumbnailURL
     * @return MediaPlayer
     */
    public function setThumbnailURL(string $thumbnailURL = null): self
    {
        $this->thumbnailURL = $thumbnailURL;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getLoop(): ?bool
    {
        return $this->loop;
    }

    /**
     * @param bool|null $loop
     * @return MediaPlayer
     */
    public function setLoop(bool $loop = null): self
    {
        $this->loop = $loop;

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
