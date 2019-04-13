<?php

declare(strict_types=1);

namespace Alserom\Viber\Request\Type;

use Alserom\Viber\Collection\UserCollection;
use Alserom\Viber\Entity\Message as MessageEntity;
use Alserom\Viber\Entity\Message\MessageEntityInterface;
use Alserom\Viber\Entity\Sender;
use Alserom\Viber\Request\AbstractApiRequest;

/**
 * Class BroadcastMessage
 * @package Alserom\Viber\Request\Type
 * @author Alexander Romanov <contact@alserom.com>
 */
class BroadcastMessage extends AbstractApiRequest
{
    public const API_METHOD = 'broadcast_message';

    private $receivers;

    private $message;

    private $sender;

    private $minApiVersion;

    /**
     * @param string $token
     * @param UserCollection $receivers
     * @param MessageEntityInterface $message
     * @param Sender|null $sender
     * @param int|null $minApiVersion
     */
    public function __construct(
        string $token,
        UserCollection $receivers,
        MessageEntityInterface $message,
        Sender $sender = null,
        int $minApiVersion = null
    ) {
        parent::__construct($token);

        $this->receivers = $receivers;
        $this->message = $message;
        $this->sender = $sender;
        $this->minApiVersion = $minApiVersion;

        foreach ($receivers as $receiver) {
            $this->addEntityToValidate($receiver);
        }
        $this->addEntityToValidate($message);
        if ($sender !== null) {
            $this->addEntityToValidate($sender);
        }
    }

    /**
     * @inheritdoc
     */
    public function getApiMethod(): string
    {
        return static::API_METHOD;
    }

    /**
     * @inheritdoc
     */
    public function getBodyData(): string
    {
        $data = [
            'min_api_version' => $this->minApiVersion,
            'type'            => $this->message->getType()
        ];

        foreach ($this->receivers as $receiver) {
            $data['broadcast_list'][] = $receiver->getId();
        }

        if ($this->sender !== null) {
            $data['sender'] = [
                'name'   => $this->sender->getName(),
                'avatar' => $this->sender->getAvatar()
            ];
        }

        $data = array_merge($this->message->toArray(), $data);

        if ($this->message instanceof MessageEntity\Keyboard) {
            unset($data['type']);
        }

        if ($this->message instanceof MessageEntity\Sticker) {
            unset($data['media']);
        }

        if ($this->message instanceof MessageEntity\Video || $this->message instanceof MessageEntity\Picture) {
            unset($data['file_name']);
        }

        $data = $this->filterData($data);

        return (string) json_encode($data);
    }
}
