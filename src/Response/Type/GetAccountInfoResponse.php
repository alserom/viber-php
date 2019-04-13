<?php

declare(strict_types=1);

namespace Alserom\Viber\Response\Type;

use Alserom\Viber\Collection\UserCollection;
use Alserom\Viber\Entity\Account;
use Alserom\Viber\Entity\Location;
use Alserom\Viber\Entity\User;
use Alserom\Viber\Entity\Webhook;
use Alserom\Viber\Exception\InvalidApiResponseException;
use Alserom\Viber\Response\AbstractApiResponse;

/**
 * Class GetAccountInfoResponse
 * @package Alserom\Viber\Response\Type
 * @author Alexander Romanov <contact@alserom.com>
 */
class GetAccountInfoResponse extends AbstractApiResponse
{
    private $account;

    /**
     * @return Account
     */
    public function getAccount(): Account
    {
        return $this->account;
    }

    /**
     * @inheritdoc
     */
    protected function populateEntities(): void
    {
        $data = $this->data;
        $id = $data['id'] ?? null;

        if ($id === null) {
            throw new InvalidApiResponseException($this->httpResponse, '"id" property missing');
        }

        $location = null;
        $lat = $data['location']['lat'] ?? null;
        $lon = $data['location']['lon'] ?? null;
        if ($lat !== null && $lon !== null) {
            $location = new Location($lat, $lon);
        }

        $webhook = null;
        $whUrl = $data['webhook'] ?? null;
        if ($whUrl !== null) {
            $webhook = new Webhook($whUrl);
            $webhook->setEventTypes($data['event_types'] ?? null);
        }

        $membersList = [];
        foreach ((array) ($data['members'] ?? []) as $user) {
            $user = (array) $user;
            $userId = $user['id'] ?? null;
            unset($user['id']);
            if ($userId !== null) {
                $member = new User($userId);
                $this->populateEntity($member, $user);
                $membersList[] = $member;
            }
        }
        $members = new UserCollection(...$membersList);

        $account = new Account($id);
        $account
            ->setLocation($location)
            ->setWebhook($webhook)
            ->setMembers($members);

        unset(
            $data['status'],
            $data['status_message'],
            $data['chat_hostname'],
            $data['id'],
            $data['location'],
            $data['webhook'],
            $data['event_types'],
            $data['members']
        );
        $this->populateEntity($account, $data);
        $this->account = $account;
    }
}
