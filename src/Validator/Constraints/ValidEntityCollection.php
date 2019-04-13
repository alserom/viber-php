<?php

declare(strict_types=1);

namespace Alserom\Viber\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Class ValidEntityCollection
 * @package Alserom\Viber\Validator\Constraints
 * @author Alexander Romanov <contact@alserom.com>
 */
class ValidEntityCollection extends Constraint
{
    public $message = 'Item on index {{ index }} is invalid.';

    public $messageItemType = 'The collection has an item with the invalid type. Each item must be a type {{ type }}.';
}
