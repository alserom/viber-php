<?php

declare(strict_types=1);

namespace Alserom\Viber\Entity;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class FavoritesMetadata
 * @package Alserom\Viber\Entity
 * @author Alexander Romanov <contact@alserom.com>
 */
class FavoritesMetadata extends AbstractEntity
{
    protected const KEYS_CASE = 'camel';

    protected $type;

    protected $url;

    protected $title;

    protected $thumbnail;

    protected $domain;

    protected $width;

    protected $height;

    protected $minApiVersion;

    protected $alternativeUrl;

    protected $alternativeText;

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return FavoritesMetadata
     */
    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @param string $url
     * @return FavoritesMetadata
     */
    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     * @return FavoritesMetadata
     */
    public function setTitle(string $title = null): self
    {
        $this->title = $title;

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
     * @return FavoritesMetadata
     */
    public function setThumbnail(string $thumbnail = null): self
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDomain(): ?string
    {
        return $this->domain;
    }

    /**
     * @param string|null $domain
     * @return FavoritesMetadata
     */
    public function setDomain(string $domain = null): self
    {
        $this->domain = $domain;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getWidth(): ?int
    {
        return $this->width;
    }

    /**
     * @param int|null $width
     * @return FavoritesMetadata
     */
    public function setWidth(int $width = null): self
    {
        $this->width = $width;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getHeight(): ?int
    {
        return $this->height;
    }

    /**
     * @param int|null $height
     * @return FavoritesMetadata
     */
    public function setHeight(int $height = null): self
    {
        $this->height = $height;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getMinApiVersion(): ?int
    {
        return $this->minApiVersion;
    }

    /**
     * @param int|null $minApiVersion
     * @return FavoritesMetadata
     */
    public function setMinApiVersion(int $minApiVersion = null): self
    {
        $this->minApiVersion = $minApiVersion;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAlternativeUrl(): ?string
    {
        return $this->alternativeUrl;
    }

    /**
     * @param string|null $alternativeUrl
     * @return FavoritesMetadata
     */
    public function setAlternativeUrl(string $alternativeUrl = null): self
    {
        $this->alternativeUrl = $alternativeUrl;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAlternativeText(): ?string
    {
        return $this->alternativeText;
    }

    /**
     * @param string|null $alternativeText
     * @return FavoritesMetadata
     */
    public function setAlternativeText(string $alternativeText = null): self
    {
        $this->alternativeText = $alternativeText;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata): void
    {
        $metadata->addPropertyConstraints('type', [
            new Assert\NotBlank(),
            new Assert\Choice(['gif', 'link', 'video'])
        ]);
        $metadata->addPropertyConstraints('url', [
            new Assert\NotBlank(),
            new Assert\Url()
        ]);
        // @TODO: Validate rules for other properties
    }
}
