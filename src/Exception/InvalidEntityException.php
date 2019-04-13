<?php

declare(strict_types=1);

namespace Alserom\Viber\Exception;

use Alserom\Viber\Entity\EntityInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Throwable;

/**
 * Class InvalidEntityException
 * @package Alserom\Viber\Exception
 * @author Alexander Romanov <contact@alserom.com>
 */
class InvalidEntityException extends \RuntimeException
{
    protected $entity;

    protected $errors;

    /**
     * @param EntityInterface $entity
     * @param ConstraintViolationListInterface $errors
     * @param Throwable|null $previous
     */
    public function __construct(
        EntityInterface $entity,
        ConstraintViolationListInterface $errors,
        Throwable $previous = null
    ) {
        $this->entity = $entity;
        $this->errors = $errors;
        $message = sprintf('Entity "%s" is invalid.', \get_class($entity));

        parent::__construct($message, 0, $previous);
    }

    /**
     * @return EntityInterface
     */
    public function getEntity(): EntityInterface
    {
        return $this->entity;
    }

    /**
     * @return ConstraintViolationListInterface
     */
    public function getErrors(): ConstraintViolationListInterface
    {
        return $this->errors;
    }
}
