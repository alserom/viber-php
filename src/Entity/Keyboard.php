<?php

declare(strict_types=1);

namespace Alserom\Viber\Entity;

use Alserom\Viber\Collection\ButtonCollection;
use Alserom\Viber\Validator\Constraints\ValidEntityCollection;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Keyboard
 * @package Alserom\Viber\Entity
 * @author Alexander Romanov <contact@alserom.com>
 */
class Keyboard extends AbstractEntity
{
    protected const KEYS_CASE = 'pascal';

    protected $type;

    protected $buttons;

    protected $bgColor;

    protected $defaultHeight;

    protected $customDefaultHeight;

    protected $heightScale;

    protected $buttonsGroupColumns;

    protected $buttonsGroupRows;

    protected $inputFieldState;

    protected $favoritesMetadata;

    public function __construct()
    {
        $this->type = 'keyboard';
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
     * @return Keyboard
     */
    public function setType(string $type): self
    {
        $this->type = $type;

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
     * @return Keyboard
     */
    public function setButtons(ButtonCollection $buttons = null): self
    {
        $this->buttons = $buttons;

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
     * @return Keyboard
     */
    public function setBgColor(string $bgColor = null): self
    {
        $this->bgColor = $bgColor;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getDefaultHeight(): ?bool
    {
        return $this->defaultHeight;
    }

    /**
     * @param bool|null $defaultHeight
     * @return Keyboard
     */
    public function setDefaultHeight(bool $defaultHeight = null): self
    {
        $this->defaultHeight = $defaultHeight;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getCustomDefaultHeight(): ?int
    {
        return $this->customDefaultHeight;
    }

    /**
     * @param int|null $customDefaultHeight
     * @return Keyboard
     */
    public function setCustomDefaultHeight(int $customDefaultHeight = null): self
    {
        $this->customDefaultHeight = $customDefaultHeight;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getHeightScale(): ?int
    {
        return $this->heightScale;
    }

    /**
     * @param int|null $heightScale
     * @return Keyboard
     */
    public function setHeightScale(int $heightScale = null): self
    {
        $this->heightScale = $heightScale;

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
     * @return Keyboard
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
     * @return Keyboard
     */
    public function setButtonsGroupRows(int $buttonsGroupRows = null): self
    {
        $this->buttonsGroupRows = $buttonsGroupRows;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getInputFieldState(): ?string
    {
        return $this->inputFieldState;
    }

    /**
     * @param string|null $inputFieldState
     * @return Keyboard
     */
    public function setInputFieldState(string $inputFieldState = null): self
    {
        $this->inputFieldState = $inputFieldState;

        return $this;
    }

    /**
     * @return FavoritesMetadata|null
     */
    public function getFavoritesMetadata(): ?FavoritesMetadata
    {
        return $this->favoritesMetadata;
    }

    /**
     * @param FavoritesMetadata|null $favoritesMetadata
     * @return Keyboard
     */
    public function setFavoritesMetadata(FavoritesMetadata $favoritesMetadata = null): self
    {
        $this->favoritesMetadata = $favoritesMetadata;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata): void
    {
        $metadata->addPropertyConstraints('type', [
            new Assert\NotBlank(),
            new Assert\Choice(['keyboard'])
        ]);
        $metadata->addPropertyConstraints('buttons', [
            new Assert\NotNull(),
            new ValidEntityCollection()
        ]);
        // @TODO: Validate rules for other properties
    }
}
