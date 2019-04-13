<?php

declare(strict_types=1);

namespace Alserom\Viber\Response\Type;

use Alserom\Viber\Collection\UserCollection;
use Alserom\Viber\Entity\User;
use Alserom\Viber\Exception\InvalidApiResponseException;
use Alserom\Viber\Response\AbstractApiResponse;

/**
 * Class GetOnlineResponse
 * @package Alserom\Viber\Response\Type
 * @author Alexander Romanov <contact@alserom.com>
 */
class GetOnlineResponse extends AbstractApiResponse
{
    private $users;

    /**
     * @return UserCollection
     */
    public function getUsers(): UserCollection
    {
        return $this->users;
    }

    /**
     * @inheritdoc
     */
    protected function populateEntities(): void
    {
        $usersList = $this->data['users'] ?? null;

        if ($usersList === null) {
            throw new InvalidApiResponseException($this->httpResponse, '"users" property missing');
        }

        $users = [];
        foreach ((array) $usersList as $item) {
            $item = (array) $item;
            $userId = $item['id'] ?? null;
            unset($item['id']);
            if ($userId !== null) {
                $user = new User($userId);
                $this->populateEntity($user, $item);
                $users[] = $user;
            }
        }

        if (!$users) {
            throw new InvalidApiResponseException($this->httpResponse, 'Invalid "users" property');
        }

        $this->users = new UserCollection(...$users);
    }
}
