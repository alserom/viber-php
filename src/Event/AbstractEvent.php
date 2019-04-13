<?php

declare(strict_types=1);

namespace Alserom\Viber\Event;

use Alserom\Viber\Entity\User;
use Alserom\Viber\Exception\InvalidEventException;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\Options;

/**
 * Class AbstractEvent
 * @package Alserom\Viber\Event
 * @author Alexander Romanov <contact@alserom.com>
 */
abstract class AbstractEvent implements EventInterface
{
    protected const TYPE = 'unknown';

    protected $data;

    protected $timestamp;

    protected $messageToken;

    protected $chatHostname;

    protected $user;

    private $dataKeys;

    /**
     * @inheritdoc
     */
    public function __construct(array $data)
    {
        $resolver = new OptionsResolver();
        $this->dataKeys = array_keys($data);
        try {
            $this->configureData($resolver);
            $this->data = $resolver->resolve($data);
            $this->populateProperties();
        } catch (\Exception $ex) {
            throw new InvalidEventException($ex->getMessage(), $data, $ex);
        }
    }

    /**
     * @param OptionsResolver $resolver
     */
    protected function configureData(OptionsResolver $resolver): void
    {
        $resolver->setDefault('chat_hostname', null);
        $resolver->setRequired([
            'event',
            'timestamp',
            'message_token',
            'chat_hostname'
        ]);
        $resolver->setAllowedTypes('event', 'string');
        $resolver->setAllowedValues('event', $this->getEventType());
        $resolver->setAllowedTypes('timestamp', 'int');
        $resolver->setAllowedTypes('message_token', ['string', 'int']);
        $resolver->setAllowedTypes('chat_hostname', ['null', 'string']);
        $resolver->setDefined($this->dataKeys);
        $resolver->setNormalizer('message_token', function (Options $options, $value) {
            return (string) $value;
        });
    }

    /**
     * @return void
     */
    protected function populateProperties(): void
    {
        $this->timestamp = $this->data['timestamp'];
        $this->messageToken = $this->data['message_token'];
        $this->chatHostname = $this->data['chat_hostname'];
        $this->user = $this->getUserFromData();
    }

    /**
     * @return User
     */
    abstract protected function getUserFromData(): User;

    /**
     * @inheritdoc
     */
    public function getEventType(): string
    {
        return static::TYPE;
    }

    /**
     * @inheritdoc
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @inheritdoc
     */
    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    /**
     * @inheritdoc
     */
    public function getMessageToken(): string
    {
        return $this->messageToken;
    }

    /**
     * @inheritdoc
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @inheritdoc
     */
    public function getChatHostname(): ?string
    {
        return $this->chatHostname;
    }
}
