<?php

declare(strict_types=1);

namespace Alserom\Viber\Collection;

use Alserom\Viber\Entity\User;

/**
 * Class UserCollection
 * @package Alserom\Viber\Collection
 * @author Alexander Romanov <contact@alserom.com>
 */
class UserCollection extends AbstractCollection
{
    /**
     * @param User $user
     * @param User ...$users
     */
    public function __construct(User $user, User ...$users)
    {
        $this->add($user);
        foreach ($users as $u) {
            $this->add($u);
        }
    }

    /**
     * @param User $user
     * @return UserCollection
     */
    public function add(User $user): self
    {
        $this->values[] = $user;

        return $this;
    }
}
