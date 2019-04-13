<?php

declare(strict_types=1);

namespace Alserom\Viber\Entity;

use Alserom\Viber\Event\EventInterface;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Webhook
 * @package Alserom\Viber\Entity
 * @author Alexander Romanov <contact@alserom.com>
 */
class Webhook extends AbstractEntity
{
    protected $url;

    protected $eventTypes;

    protected $sendName;

    protected $sendPhoto;

    /**
     * @param string|null $url
     */
    public function __construct(string $url = null)
    {
        $this->url = $url;
    }

    /**
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @param string $url
     * @return Webhook
     */
    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getEventTypes(): ?array
    {
        return $this->eventTypes;
    }

    /**
     * @param array|null $eventTypes
     * @return Webhook
     */
    public function setEventTypes(array $eventTypes = null): self
    {
        $this->eventTypes = $eventTypes;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getSendName(): ?bool
    {
        return $this->sendName;
    }

    /**
     * @param bool|null $sendName
     * @return Webhook
     */
    public function setSendName(bool $sendName = null): self
    {
        $this->sendName = $sendName;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getSendPhoto(): ?bool
    {
        return $this->sendPhoto;
    }

    /**
     * @param bool|null $sendPhoto
     * @return Webhook
     */
    public function setSendPhoto(bool $sendPhoto = null): self
    {
        $this->sendPhoto = $sendPhoto;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata): void
    {
        $metadata->addPropertyConstraints('url', [
            new Assert\NotBlank(),
            new Assert\Url(['protocols' => ['https']])
        ]);
        $metadata->addPropertyConstraint('eventTypes', new Assert\Choice([
            'choices'  => EventInterface::AVAILABLE_EVENTS,
            'multiple' => true
        ]));
    }
}
