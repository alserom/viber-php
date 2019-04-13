<?php

declare(strict_types=1);

namespace Alserom\Viber\Entity;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Button
 * @package Alserom\Viber\Entity
 * @author Alexander Romanov <contact@alserom.com>
 */
class Button extends AbstractEntity
{
    protected const KEYS_CASE = 'pascal';

    protected $columns;

    protected $rows;

    protected $silent;

    protected $bgColor;

    protected $bgMediaType;

    protected $bgMedia;

    protected $bgMediaScaleType;

    protected $bgLoop;

    protected $actionType;

    protected $actionBody;

    protected $image;

    protected $imageScaleType;

    protected $text;

    protected $textVAlign;

    protected $textHAlign;

    protected $textPaddings;

    protected $textOpacity;

    protected $textSize;

    protected $textBgGradientColor;

    protected $textShouldFit;

    protected $openURLType;

    protected $openURLMediaType;

    protected $internalBrowser;

    protected $map;

    protected $frame;

    protected $mediaPlayer;

    /**
     * @return int|null
     */
    public function getColumns(): ?int
    {
        return $this->columns;
    }

    /**
     * @param int|null $columns
     * @return Button
     */
    public function setColumns(int $columns = null): self
    {
        $this->columns = $columns;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getRows(): ?int
    {
        return $this->rows;
    }

    /**
     * @param int|null $rows
     * @return Button
     */
    public function setRows(int $rows = null): self
    {
        $this->rows = $rows;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getSilent(): ?bool
    {
        return $this->silent;
    }

    /**
     * @param bool|null $silent
     * @return Button
     */
    public function setSilent(bool $silent = null): self
    {
        $this->silent = $silent;

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
     * @return Button
     */
    public function setBgColor(string $bgColor = null): self
    {
        $this->bgColor = $bgColor;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getBgMediaType(): ?string
    {
        return $this->bgMediaType;
    }

    /**
     * @param string|null $bgMediaType
     * @return Button
     */
    public function setBgMediaType(string $bgMediaType = null): self
    {
        $this->bgMediaType = $bgMediaType;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getBgMedia(): ?string
    {
        return $this->bgMedia;
    }

    /**
     * @param string|null $bgMedia
     * @return Button
     */
    public function setBgMedia(string $bgMedia = null): self
    {
        $this->bgMedia = $bgMedia;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getBgMediaScaleType(): ?string
    {
        return $this->bgMediaScaleType;
    }

    /**
     * @param string|null $bgMediaScaleType
     * @return Button
     */
    public function setBgMediaScaleType(string $bgMediaScaleType = null): self
    {
        $this->bgMediaScaleType = $bgMediaScaleType;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getBgLoop(): ?bool
    {
        return $this->bgLoop;
    }

    /**
     * @param bool|null $bgLoop
     * @return Button
     */
    public function setBgLoop(bool $bgLoop = null): self
    {
        $this->bgLoop = $bgLoop;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getActionType(): ?string
    {
        return $this->actionType;
    }

    /**
     * @param string|null $actionType
     * @return Button
     */
    public function setActionType(string $actionType = null): self
    {
        $this->actionType = $actionType;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getActionBody(): ?string
    {
        return $this->actionBody;
    }

    /**
     * @param string|null $actionBody
     * @return Button
     */
    public function setActionBody(string $actionBody = null): self
    {
        $this->actionBody = $actionBody;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * @param string|null $image
     * @return Button
     */
    public function setImage(string $image = null): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getImageScaleType(): ?string
    {
        return $this->imageScaleType;
    }

    /**
     * @param string|null $imageScaleType
     * @return Button
     */
    public function setImageScaleType(string $imageScaleType = null): self
    {
        $this->imageScaleType = $imageScaleType;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * @param string|null $text
     * @return Button
     */
    public function setText(string $text = null): self
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTextVAlign(): ?string
    {
        return $this->textVAlign;
    }

    /**
     * @param string|null $textVAlign
     * @return Button
     */
    public function setTextVAlign(string $textVAlign = null): self
    {
        $this->textVAlign = $textVAlign;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTextHAlign(): ?string
    {
        return $this->textHAlign;
    }

    /**
     * @param string|null $textHAlign
     * @return Button
     */
    public function setTextHAlign(string $textHAlign = null): self
    {
        $this->textHAlign = $textHAlign;

        return $this;
    }

    /**
     * @return int[]|null
     */
    public function getTextPaddings(): ?array
    {
        return $this->textPaddings;
    }

    /**
     * @param int|null $top
     * @param int|null $left
     * @param int|null $bottom
     * @param int|null $right
     * @return Button
     */
    public function setTextPaddings(int $top = null, int $left = null, int $bottom = null, int $right = null): self
    {
        $this->textPaddings = [$top ?: 0, $left ?: 0, $bottom ?: 0, $right ?: 0];

        return $this;
    }

    /**
     * @return int|null
     */
    public function getTextOpacity(): ?int
    {
        return $this->textOpacity;
    }

    /**
     * @param int|null $textOpacity
     * @return Button
     */
    public function setTextOpacity(int $textOpacity = null): self
    {
        $this->textOpacity = $textOpacity;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTextSize(): ?string
    {
        return $this->textSize;
    }

    /**
     * @param string|null $textSize
     * @return Button
     */
    public function setTextSize(string $textSize = null): self
    {
        $this->textSize = $textSize;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTextBgGradientColor(): ?string
    {
        return $this->textBgGradientColor;
    }

    /**
     * @param string|null $textBgGradientColor
     * @return Button
     */
    public function setTextBgGradientColor(string $textBgGradientColor = null): self
    {
        $this->textBgGradientColor = $textBgGradientColor;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getTextShouldFit(): ?bool
    {
        return $this->textShouldFit;
    }

    /**
     * @param bool|null $textShouldFit
     * @return Button
     */
    public function setTextShouldFit(bool $textShouldFit = null): self
    {
        $this->textShouldFit = $textShouldFit;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getOpenURLType(): ?string
    {
        return $this->openURLType;
    }

    /**
     * @param string|null $openURLType
     * @return Button
     */
    public function setOpenURLType(string $openURLType = null): self
    {
        $this->openURLType = $openURLType;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getOpenURLMediaType(): ?string
    {
        return $this->openURLMediaType;
    }

    /**
     * @param string|null $openURLMediaType
     * @return Button
     */
    public function setOpenURLMediaType(string $openURLMediaType = null): self
    {
        $this->openURLMediaType = $openURLMediaType;

        return $this;
    }

    /**
     * @return InternalBrowser|null
     */
    public function getInternalBrowser(): ?InternalBrowser
    {
        return $this->internalBrowser;
    }

    /**
     * @param InternalBrowser|null $internalBrowser
     * @return Button
     */
    public function setInternalBrowser(InternalBrowser $internalBrowser = null): self
    {
        $this->internalBrowser = $internalBrowser;

        return $this;
    }

    /**
     * @return Map|null
     */
    public function getMap(): ?Map
    {
        return $this->map;
    }

    /**
     * @param Map|null $map
     * @return Button
     */
    public function setMap(Map $map = null): self
    {
        $this->map = $map;

        return $this;
    }

    /**
     * @return Frame|null
     */
    public function getFrame(): ?Frame
    {
        return $this->frame;
    }

    /**
     * @param Frame|null $frame
     * @return Button
     */
    public function setFrame(Frame $frame = null): self
    {
        $this->frame = $frame;

        return $this;
    }

    /**
     * @return MediaPlayer|null
     */
    public function getMediaPlayer(): ?MediaPlayer
    {
        return $this->mediaPlayer;
    }

    /**
     * @param MediaPlayer|null $mediaPlayer
     * @return Button
     */
    public function setMediaPlayer(MediaPlayer $mediaPlayer = null): self
    {
        $this->mediaPlayer = $mediaPlayer;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata): void
    {
        $metadata->addPropertyConstraints('actionBody', [
            new Assert\NotBlank(),
            // @TODO: more validations
        ]);
        // @TODO: Validate rules for other properties
    }
}
