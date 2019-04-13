<?php

declare(strict_types=1);

namespace Alserom\Viber\Request\Type;

use Alserom\Viber\Request\AbstractApiRequest;

/**
 * Class GetAccountInfo
 * @package Alserom\Viber\Request\Type
 * @author Alexander Romanov <contact@alserom.com>
 */
class GetAccountInfo extends AbstractApiRequest
{
    public const API_METHOD = 'get_account_info';

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
        return '';
    }
}
