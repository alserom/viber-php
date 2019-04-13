<?php

declare(strict_types=1);

namespace Alserom\Viber\Collection;

use Alserom\Viber\Entity\Button;

/**
 * Class ButtonCollection
 * @package Alserom\Viber\Collection
 * @author Alexander Romanov <contact@alserom.com>
 */
class ButtonCollection extends AbstractCollection
{
    /**
     * @param Button $button
     * @param Button ...$buttons
     */
    public function __construct(Button $button, Button ...$buttons)
    {
        $this->add($button);
        foreach ($buttons as $b) {
            $this->add($b);
        }
    }

    /**
     * @param Button $button
     * @return ButtonCollection
     */
    public function add(Button $button): self
    {
        $this->values[] = $button;

        return $this;
    }
}
