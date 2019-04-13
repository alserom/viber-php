<?php

declare(strict_types=1);

namespace Alserom\Viber\Entity;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Contact
 * @package Alserom\Viber\Entity
 * @author Alexander Romanov <contact@alserom.com>
 */
class Contact extends AbstractEntity
{
    protected $name;

    protected $phoneNumber;

    protected $avatar;

    /**
     * @param string|null $name
     * @param string|null $phoneNumber
     */
    public function __construct(string $name = null, string $phoneNumber = null)
    {
        $this->name = $name;
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Contact
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    /**
     * @param string $phoneNumber
     * @return Contact
     */
    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

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
     * @return Contact
     */
    public function setAvatar(string $avatar = null): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata): void
    {
        $metadata->addPropertyConstraints('name', [
            new Assert\NotBlank(),
            new Assert\Length(['max' => 28])
        ]);
        $metadata->addPropertyConstraints('phoneNumber', [
            new Assert\NotBlank(),
            new Assert\Length(['max' => 18])
        ]);
        $metadata->addPropertyConstraint('avatar', new Assert\Url());
    }
}
