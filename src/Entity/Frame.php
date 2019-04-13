<?php

declare(strict_types=1);

namespace Alserom\Viber\Entity;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Frame
 * @package Alserom\Viber\Entity
 * @author Alexander Romanov <contact@alserom.com>
 */
class Frame extends AbstractEntity
{
    protected const KEYS_CASE = 'pascal';

    protected $borderWidth;

    protected $borderColor;

    protected $cornerRadius;

    /**
     * @return int|null
     */
    public function getBorderWidth(): ?int
    {
        return $this->borderWidth;
    }

    /**
     * @param int|null $borderWidth
     * @return Frame
     */
    public function setBorderWidth(int $borderWidth = null): self
    {
        $this->borderWidth = $borderWidth;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getBorderColor(): ?string
    {
        return $this->borderColor;
    }

    /**
     * @param string|null $borderColor
     * @return Frame
     */
    public function setBorderColor(string $borderColor = null): self
    {
        $this->borderColor = $borderColor;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getCornerRadius(): ?int
    {
        return $this->cornerRadius;
    }

    /**
     * @param int|null $cornerRadius
     * @return Frame
     */
    public function setCornerRadius(int $cornerRadius = null): self
    {
        $this->cornerRadius = $cornerRadius;

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
