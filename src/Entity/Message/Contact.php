<?php

declare(strict_types=1);

namespace Alserom\Viber\Entity\Message;

use Alserom\Viber\Validator\Constraints\ValidEntity;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;
use Alserom\Viber\Entity\Contact as ContactEntity;

/**
 * Class Contact
 * @package Alserom\Viber\Entity\Message
 * @author Alexander Romanov <contact@alserom.com>
 */
class Contact extends AbstractMessage
{
    public const TYPE = 'contact';

    protected $contact;

    /**
     * @inheritdoc
     */
    public function getType(): string
    {
        return self::TYPE;
    }

    /**
     * @return ContactEntity|null
     */
    public function getContact(): ?ContactEntity
    {
        return $this->contact;
    }

    /**
     * @param ContactEntity $contact
     * @return Contact
     */
    public function setContact(ContactEntity $contact): self
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata): void
    {
        $metadata->addPropertyConstraints('contact', [
            new Assert\NotNull(),
            new ValidEntity()
        ]);

        parent::loadValidatorMetadata($metadata);
    }
}
