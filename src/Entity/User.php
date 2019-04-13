<?php

declare(strict_types=1);

namespace Alserom\Viber\Entity;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class User
 * @package Alserom\Viber\Entity
 * @author Alexander Romanov <contact@alserom.com>
 */
class User extends AbstractEntity
{
    protected $id;

    protected $name;

    protected $avatar;

    protected $country;

    protected $language;

    protected $primaryDeviceOs;

    protected $apiVersion;

    protected $viberVersion;

    protected $mcc;

    protected $mnc;

    protected $deviceType;

    protected $onlineStatus;

    protected $onlineStatusMessage;

    protected $lastOnline;

    protected $role;

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
     * @return User
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
     * @return User
     */
    public function setName(string $name = null): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    /**
     * @param string|null $avatar
     * @return User
     */
    public function setAvatar(string $avatar = null): self
    {
        $this->avatar = $avatar;

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
     * @return User
     */
    public function setCountry(string $country = null): self
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLanguage(): ?string
    {
        return $this->language;
    }

    /**
     * @param string|null $language
     * @return User
     */
    public function setLanguage(string $language = null): self
    {
        $this->language = $language;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPrimaryDeviceOs(): ?string
    {
        return $this->primaryDeviceOs;
    }

    /**
     * @param string|null $primaryDeviceOs
     * @return User
     */
    public function setPrimaryDeviceOs(string $primaryDeviceOs = null): self
    {
        $this->primaryDeviceOs = $primaryDeviceOs;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getApiVersion(): ?int
    {
        return $this->apiVersion;
    }

    /**
     * @param int|null $apiVersion
     * @return User
     */
    public function setApiVersion(int $apiVersion = null): self
    {
        $this->apiVersion = $apiVersion;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getViberVersion(): ?string
    {
        return $this->viberVersion;
    }

    /**
     * @param string|null $viberVersion
     * @return User
     */
    public function setViberVersion(string $viberVersion = null): self
    {
        $this->viberVersion = $viberVersion;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getMcc(): ?int
    {
        return $this->mcc;
    }

    /**
     * @param int|null $mcc
     * @return User
     */
    public function setMcc(int $mcc = null): self
    {
        $this->mcc = $mcc;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getMnc(): ?int
    {
        return $this->mnc;
    }

    /**
     * @param int|null $mnc
     * @return User
     */
    public function setMnc(int $mnc = null): self
    {
        $this->mnc = $mnc;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDeviceType(): ?string
    {
        return $this->deviceType;
    }

    /**
     * @param string|null $deviceType
     * @return User
     */
    public function setDeviceType(string $deviceType = null): self
    {
        $this->deviceType = $deviceType;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getOnlineStatus(): ?int
    {
        return $this->onlineStatus;
    }

    /**
     * @param int|null $onlineStatus
     * @return User
     */
    public function setOnlineStatus(int $onlineStatus = null): self
    {
        $this->onlineStatus = $onlineStatus;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getOnlineStatusMessage(): ?string
    {
        return $this->onlineStatusMessage;
    }

    /**
     * @param string|null $onlineStatusMessage
     * @return User
     */
    public function setOnlineStatusMessage(string $onlineStatusMessage = null): self
    {
        $this->onlineStatusMessage = $onlineStatusMessage;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getLastOnline(): ?int
    {
        return $this->lastOnline;
    }

    /**
     * @param int|null $lastOnline
     * @return User
     */
    public function setLastOnline(int $lastOnline = null): self
    {
        $this->lastOnline = $lastOnline;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getRole(): ?string
    {
        return $this->role;
    }

    /**
     * @param string|null $role
     * @return User
     */
    public function setRole(string $role = null): self
    {
        $this->role = $role;

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
