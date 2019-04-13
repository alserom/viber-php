<?php

namespace Alserom\Viber\Entity;

use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * Interface EntityInterface
 * @package Alserom\Viber\Entity
 * @author Alexander Romanov <contact@alserom.com>
 */
interface EntityInterface extends \Serializable, \JsonSerializable
{
    /**
     * @param ClassMetadata $metadata
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata): void;

    /**
     * @return array
     */
    public function toArray(): array;

    /**
     * @param array $data
     * @return static
     */
    public static function fromArray(array $data);
}
