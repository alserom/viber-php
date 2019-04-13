<?php

namespace Alserom\Viber\Collection;

/**
 * Interface CollectionInterface
 * @package Alserom\Viber\Collection
 * @author Alexander Romanov <contact@alserom.com>
 */
interface CollectionInterface extends \IteratorAggregate, \Countable
{
    /**
     * @return array
     */
    public function toArray(): array;
}
