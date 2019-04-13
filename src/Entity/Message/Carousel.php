<?php

declare(strict_types=1);

namespace Alserom\Viber\Entity\Message;

use Alserom\Viber\Entity\RichMedia;
use Alserom\Viber\Validator\Constraints\ValidEntity;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Carousel
 * @package Alserom\Viber\Entity\Message
 * @author Alexander Romanov <contact@alserom.com>
 */
class Carousel extends AbstractMessage
{
    public const TYPE = 'rich_media';

    protected $altText;

    protected $richMedia;

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
    public function getAltText(): ?string
    {
        return $this->altText;
    }

    /**
     * @param string|null $altText
     * @return Carousel
     */
    public function setAltText(string $altText = null): self
    {
        $this->altText = $altText;

        return $this;
    }

    /**
     * @return RichMedia|null
     */
    public function getRichMedia(): ?RichMedia
    {
        return $this->richMedia;
    }

    /**
     * @param RichMedia|null $richMedia
     * @return Carousel
     */
    public function setRichMedia(RichMedia $richMedia = null): self
    {
        $this->richMedia = $richMedia;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata): void
    {
        $metadata->addPropertyConstraints('richMedia', [
            new Assert\NotNull(),
            new ValidEntity()
        ]);
        $metadata->addPropertyConstraint('altText', new Assert\Length(['max' => 7000]));

        parent::loadValidatorMetadata($metadata);
    }
}
