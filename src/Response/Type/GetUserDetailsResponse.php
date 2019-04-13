<?php

declare(strict_types=1);

namespace Alserom\Viber\Response\Type;

use Alserom\Viber\Entity\User;
use Alserom\Viber\Exception\InvalidApiResponseException;
use Alserom\Viber\Response\AbstractApiResponse;

/**
 * Class GetUserDetailsResponse
 * @package Alserom\Viber\Response\Type
 * @author Alexander Romanov <contact@alserom.com>
 */
class GetUserDetailsResponse extends AbstractApiResponse
{
    private $user;

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @inheritdoc
     */
    protected function populateEntities(): void
    {
        $userData = $this->data['user'] ?? [];
        $id = $userData['id'] ?? null;

        if ($id === null) {
            throw new InvalidApiResponseException($this->httpResponse, '"user.id" property missing');
        }

        unset($userData['id']);
        $user = new User($id);
        $this->populateEntity($user, $userData);

        $this->user = $user;
    }
}
