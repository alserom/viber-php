<?php

declare(strict_types=1);

namespace Alserom\Viber\Entity;

use Alserom\Viber\Collection\UserCollection;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Account
 * @package Alserom\Viber\Entity
 * @author Alexander Romanov <contact@alserom.com>
 */
class Account extends AbstractEntity
{
    protected $id;

    protected $name;

    protected $uri;

    protected $icon;

    protected $background;

    protected $category;

    protected $subcategory;

    protected $location;

    protected $country;

    protected $webhook;

    protected $subscribersCount;

    protected $members;

    protected $chatFlags;

    /**
     * @param string|null $id
     */
    public function __construct(string $id = null)
    {
        $this->id = $id;
    }

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return Account
     */
    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return Account
     */
    public function setName(string $name = null): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getUri(): ?string
    {
        return $this->uri;
    }

    /**
     * @param string|null $uri
     * @return Account
     */
    public function setUri(string $uri = null): self
    {
        $this->uri = $uri;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getIcon(): ?string
    {
        return $this->icon;
    }

    /**
     * @param string|null $icon
     * @return Account
     */
    public function setIcon(string $icon = null): self
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getBackground(): ?string
    {
        return $this->background;
    }

    /**
     * @param string|null $background
     * @return Account
     */
    public function setBackground(string $background = null): self
    {
        $this->background = $background;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCategory(): ?string
    {
        return $this->category;
    }

    /**
     * @param string|null $category
     * @return Account
     */
    public function setCategory(string $category = null): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSubcategory(): ?string
    {
        return $this->subcategory;
    }

    /**
     * @param string|null $subcategory
     * @return Account
     */
    public function setSubcategory(string $subcategory = null): self
    {
        $this->subcategory = $subcategory;

        return $this;
    }

    /**
     * @return Location|null
     */
    public function getLocation(): ?Location
    {
        return $this->location;
    }

    /**
     * @param Location|null $location
     * @return Account
     */
    public function setLocation(Location $location = null): self
    {
        $this->location = $location;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCountry(): ?string
    {
        return $this->country;
    }

    /**
     * @param string|null $country
     * @return Account
     */
    public function setCountry(string $country = null): self
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return Webhook|null
     */
    public function getWebhook(): ?Webhook
    {
        return $this->webhook;
    }

    /**
     * @param Webhook|null $webhook
     * @return Account
     */
    public function setWebhook(Webhook $webhook = null): self
    {
        $this->webhook = $webhook;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getSubscribersCount(): ?int
    {
        return $this->subscribersCount;
    }

    /**
     * @param int|null $subscribersCount
     * @return Account
     */
    public function setSubscribersCount(int $subscribersCount = null): self
    {
        $this->subscribersCount = $subscribersCount;

        return $this;
    }

    /**
     * @return UserCollection|null
     */
    public function getMembers(): ?UserCollection
    {
        return $this->members;
    }

    /**
     * @param UserCollection $members
     * @return Account
     */
    public function setMembers(UserCollection $members): self
    {
        $this->members = $members;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getChatFlags(): ?array
    {
        return $this->chatFlags;
    }

    /**
     * @param array|null $chatFlags
     * @return Account
     */
    public function setChatFlags(array $chatFlags = null): self
    {
        $this->chatFlags = $chatFlags;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata): void
    {
        $metadata->addPropertyConstraint('id', new Assert\NotBlank());
        // @TODO: Validate rules for other properties
    }
}
