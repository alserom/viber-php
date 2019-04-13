<?php

declare(strict_types=1);

namespace Alserom\Viber\Request\Type;

use Alserom\Viber\Entity\User;
use Alserom\Viber\Request\AbstractApiRequest;

/**
 * Class GetUserDetails
 * @package Alserom\Viber\Request\Type
 * @author Alexander Romanov <contact@alserom.com>
 */
class GetUserDetails extends AbstractApiRequest
{
    public const API_METHOD = 'get_user_details';

    private $user;

    /**
     * @param string $token
     * @param User $user
     */
    public function __construct(string $token, User $user)
    {
        parent::__construct($token);

        $this->user = $user;
        $this->addEntityToValidate($user);
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
        $data = ['id' => $this->user->getId()];

        return (string) json_encode($data);
    }
}
