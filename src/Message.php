<?php

declare(strict_types=1);

namespace Alserom\Viber;

use Alserom\Viber\Collection\UserCollection;
use Alserom\Viber\Entity\Message\MessageEntityFactory;
use Alserom\Viber\Entity\Message\MessageEntityInterface;
use Alserom\Viber\Entity\Sender;
use Alserom\Viber\Entity\User;

/**
 * Class Message
 * @package Alserom\Viber
 * @author Alexander Romanov <contact@alserom.com>
 *
 * @method string getType()
 * @method string|null getTrackingData()
 * @method Message setTrackingData(string $trackingData = null)
 * @method \Alserom\Viber\Entity\Keyboard|null getKeyboard()
 * @method Message setKeyboard(\Alserom\Viber\Entity\Keyboard $keyboard = null)
 * @method string|null getAltText()
 * @method Message setAltText(string $altText = null)
 * @method \Alserom\Viber\Entity\RichMedia|null getRichMedia()
 * @method Message setRichMedia(\Alserom\Viber\Entity\RichMedia $richMedia = null)
 * @method \Alserom\Viber\Entity\Contact|null getContact()
 * @method Message setContact(\Alserom\Viber\Entity\Contact $contact)
 * @method string|null getMedia()
 * @method Message setMedia(string $media)
 * @method int|null getSize()
 * @method Message setSize(int $size)
 * @method string|null getFileName()
 * @method Message setFileName(string $fileName)
 * @method \Alserom\Viber\Entity\Location|null getLocation()
 * @method Message setLocation(\Alserom\Viber\Entity\Location $location)
 * @method string|null getText()
 * @method Message setText(string $text)
 * @method string|null getThumbnail()
 * @method Message setThumbnail(string $thumbnail = null)
 * @method int|null getStickerId()
 * @method Message setStickerId(int $stickerId)
 * @method int|null getDuration()
 * @method Message setDuration(int $duration = null)
 */
final class Message
{
    public const DEFAULT_TYPE = 'text';

    protected $from;

    protected $to;

    protected $entity;

    protected $minApiVersion;

    protected $sender;

    /**
     * @param string|null $type
     * @throws \InvalidArgumentException
     */
    public function __construct(string $type = null)
    {
        $this->entity = MessageEntityFactory::create($type ?: self::DEFAULT_TYPE);
    }

    /**
     * @inheritdoc
     */
    public function __call(string $method, array $args)
    {
        $res = $this->getEntity()->$method(...$args);

        if (\is_object($res) && \get_class($res) === \get_class($this->entity)) {
            return $this;
        }

        return $res;
    }

    /**
     * @return User|null
     */
    public function getFrom(): ?User
    {
        return $this->from;
    }

    /**
     * @param User|null $from
     * @return Message
     */
    public function setFrom(User $from = null): self
    {
        $this->from = $from;

        return $this;
    }

    /**
     * @param User $user
     * @param User ...$users
     * @return Message
     */
    public function setTo(User $user, User ...$users): self
    {
        $this->to = new UserCollection($user, ...$users);

        return $this;
    }

    /**
     * @param User $user
     * @param User ...$users
     * @return Message
     */
    public function addTo(User $user, User ...$users): self
    {
        if (!$this->to instanceof UserCollection) {
            return $this->setTo($user, ...$users);
        }

        $this->to->add($user);
        foreach ($users as $recipient) {
            $this->to->add($recipient);
        }

        return $this;
    }

    /**
     * @return UserCollection|null
     */
    public function getTo(): ?UserCollection
    {
        return $this->to;
    }

    /**
     * @return MessageEntityInterface
     */
    public function getEntity(): MessageEntityInterface
    {
        return $this->entity;
    }

    /**
     * @param MessageEntityInterface $messageEntity
     * @return Message
     */
    public function setEntity(MessageEntityInterface $messageEntity): self
    {
        $this->entity = $messageEntity;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getMinApiVersion(): ?int
    {
        return $this->minApiVersion;
    }

    /**
     * @param int|null $version
     * @return Message
     */
    public function setMinApiVersion(int $version = null): self
    {
        $this->minApiVersion = $version;

        return $this;
    }

    /**
     * @return Sender|null
     */
    public function getSender(): ?Sender
    {
        return $this->sender;
    }

    /**
     * @param Sender|null $sender
     * @return Message
     */
    public function setSender(Sender $sender = null): self
    {
        $this->sender = $sender;

        return $this;
    }
}
