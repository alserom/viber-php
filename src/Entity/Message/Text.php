<?php

declare(strict_types=1);

namespace Alserom\Viber\Entity\Message;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Text
 * @package Alserom\Viber\Entity\Message
 * @author Alexander Romanov <contact@alserom.com>
 */
class Text extends AbstractMessage
{
    public const TYPE = 'text';

    protected $text;

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
     * @return Text
     */
    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata): void
    {
        $metadata->addPropertyConstraint('text', new Assert\NotBlank());

        parent::loadValidatorMetadata($metadata);
    }
}
