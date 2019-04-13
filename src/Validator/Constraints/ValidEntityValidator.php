<?php

declare(strict_types=1);

namespace Alserom\Viber\Validator\Constraints;

use Alserom\Viber\Entity\EntityInterface;
use Alserom\Viber\Exception\InvalidEntityException;
use Alserom\Viber\Validator\EntityValidator;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

/**
 * Class ValidEntityValidator
 * @package Alserom\Viber\Validator\Constraints
 * @author Alexander Romanov <contact@alserom.com>
 */
class ValidEntityValidator extends ConstraintValidator
{
    /**
     * @inheritdoc
     * @throws \Exception
     */
    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof ValidEntity) {
            throw new UnexpectedTypeException($constraint, ValidEntity::class);
        }

        if ($value === null) {
            return;
        }

        if (!$value instanceof EntityInterface) {
            throw new UnexpectedValueException($value, EntityInterface::class);
        }

        try {
            EntityValidator::validate($value);
        } catch (InvalidEntityException $ex) {
            $message = $ex->getMessage();
            $errors = [];
            foreach ($ex->getErrors() as $error) {
                $errors[] = $error->getMessage();
            }
            $message .= ' (' . implode(' | ', $errors) . ')';
            $this->context->buildViolation($message)->addViolation();
        } catch (\Exception $ex) {
            throw $ex;
        }
    }
}
