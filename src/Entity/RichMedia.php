<?php

declare(strict_types=1);

namespace Alserom\Viber\Entity;

use Alserom\Viber\Collection\ButtonCollection;
use Alserom\Viber\Validator\Constraints\ValidEntityCollection;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class RichMedia
 * @package Alserom\Viber\Entity
 * @author Alexander Romanov <contact@alserom.com>
 */
class RichMedia
{
    protected const KEYS_CASE = 'pascal';

    protected $type;

    protected $buttonsGroupColumns;

    protected $buttonsGroupRows;

    protected $bgColor;

    protected $buttons;

    public function __construct()
    {
        $this->type = 'rich_media';
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return RichMedia
     */
    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getButtonsGroupColumns(): ?int
    {
        return $this->buttonsGroupColumns;
    }

    /**
     * @param int|null $buttonsGroupColumns
     * @return RichMedia
     */
    public function setButtonsGroupColumns(int $buttonsGroupColumns = null): self
    {
        $this->buttonsGroupColumns = $buttonsGroupColumns;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getButtonsGroupRows(): ?int
    {
        return $this->buttonsGroupRows;
    }

    /**
     * @param int|null $buttonsGroupRows
     * @return RichMedia
     */
    public function setButtonsGroupRows(int $buttonsGroupRows = null): self
    {
        $this->buttonsGroupRows = $buttonsGroupRows;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getBgColor(): ?string
    {
        return $this->bgColor;
    }

    /**
     * @param string|null $bgColor
     * @return RichMedia
     */
    public function setBgColor(string $bgColor = null): self
    {
        $this->bgColor = $bgColor;

        return $this;
    }

    /**
     * @return ButtonCollection|null
     */
    public function getButtons(): ?ButtonCollection
    {
        return $this->buttons;
    }

    /**
     * @param ButtonCollection|null $buttons
     * @return RichMedia
     */
    public function setButtons(ButtonCollection $buttons = null): self
    {
        $this->buttons = $buttons;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata): void
    {
        $metadata->addPropertyConstraints('type', [
            new Assert\NotBlank(),
            new Assert\Choice(['rich_media'])
        ]);
        $metadata->addPropertyConstraints('buttons', [
            new Assert\NotNull(),
            new ValidEntityCollection()
        ]);
        // @TODO: Validate rules for other properties
    }
}
