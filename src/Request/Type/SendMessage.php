<?php

declare(strict_types=1);

namespace Alserom\Viber\Request\Type;

use Alserom\Viber\Collection\UserCollection;
use Alserom\Viber\Entity\Message\MessageEntityInterface;
use Alserom\Viber\Entity\Sender;
use Alserom\Viber\Entity\User;

/**
 * Class SendMessage
 * @package Alserom\Viber\Request\Type
 * @author Alexander Romanov <contact@alserom.com>
 */
class SendMessage extends BroadcastMessage
{
    public const API_METHOD = 'send_message';

    private $receiver;

    /**
     * @param string $token
     * @param User $receiver
     * @param MessageEntityInterface $message
     * @param Sender|null $sender
     * @param int|null $minApiVersion
     */
    public function __construct(
        string $token,
        User $receiver,
        MessageEntityInterface $message,
        Sender $sender = null,
        int $minApiVersion = null
    ) {
        $this->receiver = $receiver;

        parent::__construct($token, new UserCollection($receiver), $message, $sender, $minApiVersion);
    }

    /**
     * @inheritdoc
     */
    public function getBodyData(): string
    {
        $data = json_decode(parent::getBodyData(), true);
        unset($data['broadcast_list']);
        $data['receiver'] = $this->receiver->getId();

        return (string) json_encode($data);
    }
}
