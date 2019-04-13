<?php

declare(strict_types=1);

namespace Alserom\Viber\Request\Type;

use Alserom\Viber\Collection\UserCollection;
use Alserom\Viber\Request\AbstractApiRequest;

/**
 * Class GetOnline
 * @package Alserom\Viber\Request\Type
 * @author Alexander Romanov <contact@alserom.com>
 */
class GetOnline extends AbstractApiRequest
{
    public const API_METHOD = 'get_online';

    private $users;

    /**
     * @param string $token
     * @param UserCollection $users
     */
    public function __construct(string $token, UserCollection $users)
    {
        parent::__construct($token);

        $this->users = $users;
        foreach ($users as $user) {
            $this->addEntityToValidate($user);
        }
    }

    /**
     * @inheritdoc
     */
    public function getApiMethod(): string
    {
        return self::API_METHOD;
    }

    /**
     * @inheritdoc
     */
    public function getBodyData(): string
    {
        $ids = [];
        foreach ($this->users as $user) {
            $ids[] = $user->getId();
        }

        $data = ['ids' => $ids];

        return (string) json_encode($data);
    }
}
