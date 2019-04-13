<?php

declare(strict_types=1);

namespace Alserom\Viber\Response\Type;

/**
 * Class BroadcastMessageResponse
 * @package Alserom\Viber\Response\Type
 * @author Alexander Romanov <contact@alserom.com>
 */
class BroadcastMessageResponse extends SendMessageResponse
{
    private $failedList;

    /**
     * @return array
     */
    public function getFailedList(): array
    {
        return (array) $this->failedList;
    }

    /**
     * @inheritdoc
     */
    protected function populateEntities(): void
    {
        parent::populateEntities();

        $this->failedList = $this->data['failed_list'] ?? [];
    }
}
