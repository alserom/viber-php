<?php

declare(strict_types=1);

namespace Alserom\Viber\Validator;

use Alserom\Viber\Entity\EntityInterface;
use Alserom\Viber\Exception\InvalidEntityException;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class EntityValidator
 * @package Alserom\Viber\Validator
 * @author Alexander Romanov <contact@alserom.com>
 */
final class EntityValidator
{
    /** @var ValidatorInterface */
    private static $validator;

    /**
     * @param EntityInterface $entity
     * @throws InvalidEntityException
     */
    public static function validate(EntityInterface $entity): void
    {
        if (!static::$validator instanceof ValidatorInterface) {
            static::$validator = Validation::createValidatorBuilder()
                ->addMethodMapping('loadValidatorMetadata')->getValidator();
        }

        $violations = static::$validator->validate($entity);
        if (\count($violations) !== 0) {
            throw new InvalidEntityException($entity, $violations);
        }
    }

    /**
     * Prevent functional
     */
    private function __construct()
    {
    }

    /**
     * Prevent functional
     */
    private function __clone()
    {
    }

    /**
     * Prevent functional
     */
    public function __wakeup()
    {
        throw new \LogicException('Deny');
    }
}
