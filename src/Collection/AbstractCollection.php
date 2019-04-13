<?php

declare(strict_types=1);

namespace Alserom\Viber\Collection;

/**
 * Class AbstractCollection
 * @package Alserom\Viber\Collection
 * @author Alexander Romanov <contact@alserom.com>
 */
abstract class AbstractCollection implements CollectionInterface
{
    protected $values = [];

    /**
     * @inheritdoc
     */
    public function toArray(): array
    {
        return $this->values;
    }

    /**
     * @inheritdoc
     */
    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->values);
    }

    /**
     * @inheritdoc
     */
    public function count(): int
    {
        return \count($this->values);
    }
}
