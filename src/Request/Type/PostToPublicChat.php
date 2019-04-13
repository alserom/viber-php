<?php

declare(strict_types=1);

namespace Alserom\Viber\Request\Type;

use Alserom\Viber\Collection\UserCollection;
use Alserom\Viber\Entity\Message\MessageEntityInterface;
use Alserom\Viber\Entity\Sender;
use Alserom\Viber\Entity\User;

/**
 * Class PostToPublicChat
 * @package Alserom\Viber\Request\Type
 * @author Alexander Romanov <contact@alserom.com>
 */
class PostToPublicChat extends BroadcastMessage
{
    public const API_METHOD = 'post';

    private $from;

    /**
     * @param string $token
     * @param User $from
     * @param MessageEntityInterface $message
     * @param Sender|null $sender
     * @param int|null $minApiVersion
     */
    public function __construct(
        string $token,
        User $from,
        MessageEntityInterface $message,
        Sender $sender = null,
        int $minApiVersion = null
    ) {
        $this->from = $from;

        parent::__construct($token, new UserCollection($from), $message, $sender, $minApiVersion);
    }

    /**
     * @inheritdoc
     */
    public function getBodyData(): string
    {
        $data = json_decode(parent::getBodyData(), true);
        unset($data['broadcast_list'], $data['keyboard']);
        $data['from'] = $this->from->getId();

        return (string) json_encode($data);
    }
}
