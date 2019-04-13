<?php

declare(strict_types=1);

namespace Alserom\Viber\Response\Type;

use Alserom\Viber\Entity\User;

/**
 * Class GetUserOnlineResponse
 * @package Alserom\Viber\Response\Type
 * @author Alexander Romanov <contact@alserom.com>
 */
class GetUserOnlineResponse extends GetOnlineResponse
{
    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->getUsers()->toArray()[0];
    }
}
