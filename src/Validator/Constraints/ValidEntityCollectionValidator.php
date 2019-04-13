<?php

declare(strict_types=1);

namespace Alserom\Viber\Validator\Constraints;

use Alserom\Viber\Collection\CollectionInterface;
use Alserom\Viber\Entity\EntityInterface;
use Alserom\Viber\Exception\InvalidEntityException;
use Alserom\Viber\Validator\EntityValidator;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

/**
 * Class ValidEntityCollectionValidator
 * @package Alserom\Viber\Validator\Constraints
 * @author Alexander Romanov <contact@alserom.com>
 */
class ValidEntityCollectionValidator extends ConstraintValidator
{
    /**
     * @inheritdoc
     * @throws \Exception
     */
    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof ValidEntityCollection) {
            throw new UnexpectedTypeException($constraint, ValidEntityCollection::class);
        }

        if ($value === null) {
            return;
        }

        if (!$value instanceof CollectionInterface) {
            throw new UnexpectedValueException($value, CollectionInterface::class);
        }

        foreach ($value->toArray() as $i => $entity) {
            if (!$entity instanceof EntityInterface) {
                $this->context->buildViolation($constraint->messageItemType)
                    ->setParameter('{{ type }}', EntityInterface::class)
                    ->addViolation();
                break;
            }

            try {
                EntityValidator::validate($entity);
            } catch (InvalidEntityException $ex) {
                $message = $ex->getMessage();
                $errors = [];
                foreach ($ex->getErrors() as $error) {
                    $errors[] = $error->getMessage();
                }
                $message .= ' (' . implode(' | ', $errors) . ')';

                $this->context->buildViolation($constraint->message . ' ' . $message)
                    ->setParameter('{{ index }}', $i)
                    ->addViolation();
                break;
            } catch (\Exception $ex) {
                throw $ex;
            }
        }
    }
}
