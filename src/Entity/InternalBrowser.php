<?php

declare(strict_types=1);

namespace Alserom\Viber\Entity;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class InternalBrowser
 * @package Alserom\Viber\Entity
 * @author Alexander Romanov <contact@alserom.com>
 */
class InternalBrowser extends AbstractEntity
{
    protected const KEYS_CASE = 'pascal';

    protected $actionButton;

    protected $actionPredefinedURL;

    protected $titleType;

    protected $customTitle;

    protected $mode;

    protected $footerType;

    protected $actionReplyData;

    /**
     * @return string|null
     */
    public function getActionButton(): ?string
    {
        return $this->actionButton;
    }

    /**
     * @param string|null $actionButton
     * @return InternalBrowser
     */
    public function setActionButton(string $actionButton = null): self
    {
        $this->actionButton = $actionButton;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getActionPredefinedURL(): ?string
    {
        return $this->actionPredefinedURL;
    }

    /**
     * @param string|null $actionPredefinedURL
     * @return InternalBrowser
     */
    public function setActionPredefinedURL(string $actionPredefinedURL = null): self
    {
        $this->actionPredefinedURL = $actionPredefinedURL;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTitleType(): ?string
    {
        return $this->titleType;
    }

    /**
     * @param string|null $titleType
     * @return InternalBrowser
     */
    public function setTitleType(string $titleType = null): self
    {
        $this->titleType = $titleType;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCustomTitle(): ?string
    {
        return $this->customTitle;
    }

    /**
     * @param string|null $customTitle
     * @return InternalBrowser
     */
    public function setCustomTitle(string $customTitle = null): self
    {
        $this->customTitle = $customTitle;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getMode(): ?string
    {
        return $this->mode;
    }

    /**
     * @param string|null $mode
     * @return InternalBrowser
     */
    public function setMode(string $mode = null): self
    {
        $this->mode = $mode;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFooterType(): ?string
    {
        return $this->footerType;
    }

    /**
     * @param string|null $footerType
     * @return InternalBrowser
     */
    public function setFooterType(string $footerType = null): self
    {
        $this->footerType = $footerType;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getActionReplyData(): ?string
    {
        return $this->actionReplyData;
    }

    /**
     * @param string|null $actionReplyData
     * @return InternalBrowser
     */
    public function setActionReplyData(string $actionReplyData = null): self
    {
        $this->actionReplyData = $actionReplyData;

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
