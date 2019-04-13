<?php

declare(strict_types=1);

namespace Alserom\Viber\Entity;

use Alserom\Viber\Collection\CollectionInterface;

/**
 * Class AbstractEntity
 * @package Alserom\Viber\Entity
 * @author Alexander Romanov <contact@alserom.com>
 */
abstract class AbstractEntity implements EntityInterface
{
    protected const KEYS_CASE = 'snake';

    /**
     * @inheritdoc
     */
    public function serialize(): string
    {
        return serialize($this->filterArray($this->toArray()));
    }

    /**
     * @inheritdoc
     * @throws \ReflectionException
     */
    public function unserialize($serialized): void
    {
        $data = (array) unserialize($serialized, ['allowed_classes' => false]);
        $this->populateFromArray($data);
    }

    /**
     * @inheritdoc
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    /**
     * @inheritdoc
     */
    public function toArray(): array
    {
        $data = $this->normalizeKeys(get_object_vars($this));
        $data = $this->normalizeValues($data);

        return $data;
    }

    /**
     * @inheritdoc
     */
    public static function fromArray(array $data)
    {
        $obj = new static();
        $obj->populateFromArray($data);

        return $obj;
    }

    /**
     * @TODO: Attention, shitcode here. Need to think about this.
     *
     * @param array $data
     * @throws \ReflectionException
     */
    private function populateFromArray(array $data): void
    {
        $refClass = new \ReflectionClass($this);
        foreach ($data as $property => $value) {
            if ($value === null) {
                continue;
            }

            $method = $this->getSetterName($property);
            $refMethod = $refClass->hasMethod($method) ? $refClass->getMethod($method) : null;
            if ($refMethod && $refMethod->isPublic() && $pNums = $refMethod->getNumberOfParameters()) {
                $refParams = $refMethod->getParameters();
                if ($pNums > 1 && \is_array($value)) {
                    $this->$method(...$value);
                } else {
                    $refParamType = $refParams[0]->getType();
                    if ($refParamType && !$refParamType->isBuiltin()) {
                        $type = $refParamType->getName();
                        if (is_subclass_of($type, EntityInterface::class)) {
                            $this->$method($type::fromArray((array) $value));
                        } elseif (is_subclass_of($type, CollectionInterface::class)) {
                            $ref = new \ReflectionClass($type);
                            $refMethod = $ref->getConstructor();
                            if ($refMethod === null) {
                                continue;
                            }
                            $refT = ($refMethod->getNumberOfParameters() && $refMethod->getParameters()[0]->getType()) ?
                                $refMethod->getParameters()[0]->getType() : null;
                            $t = $refT ? $refT->getName() : null;
                            if ($t && is_subclass_of($t, EntityInterface::class)) {
                                $params = [];
                                foreach ((array)$value as $item) {
                                    $params[] = $t::fromArray((array) $item);
                                }
                                $this->$method(new $type(...$params));
                            }
                        }
                    } else {
                        $this->$method($value);
                    }
                }
            }
        }
    }

    /**
     * @param string $property
     * @return string
     */
    private function getSetterName(string $property): string
    {
        $property = preg_replace_callback(
            '/_([a-z])/u',
            function ($matches) {
                return strtoupper($matches[1]);
            },
            lcfirst($property)
        );

        return 'set' . ucfirst((string) $property);
    }

    /**
     * @param array $data
     * @return array
     */
    private function normalizeKeys(array $data): array
    {
        $case = \in_array(static::KEYS_CASE, ['snake', 'pascal', 'camel']) ? static::KEYS_CASE : self::KEYS_CASE;

        $newData = [];
        foreach ($data as $key => $value) {
            if (!\is_int($key)) {
                switch ($case) {
                    case 'pascal':
                        $key = ucfirst($key);
                        break;
                    case 'snake':
                        if (!ctype_lower($key)) {
                            $key = strtolower((string) preg_replace('/(.)(?=[A-Z])/u', '$1_', $key));
                        }
                        break;
                }
            }
            $newData[$key] = $value;
        }

        return $newData;
    }

    /**
     * @param array $data
     * @return array
     */
    private function normalizeValues(array $data): array
    {
        $newData = [];
        foreach ($data as $key => $value) {
            if ($value instanceof EntityInterface) {
                $newData[$key] = $value->toArray();
            } elseif ($value instanceof CollectionInterface) {
                $newData[$key] = $this->normalizeValues($value->toArray());
            } else {
                $newData[$key] = $value;
            }
        }

        return $newData;
    }

    /**
     * @param array $data
     * @return array
     */
    private function filterArray(array $data): array
    {
        foreach ($data as $key => $value) {
            if (\is_array($value)) {
                $data[$key] = $this->filterArray($value);
            }

            if ($data[$key] === null || $data[$key] === []) {
                unset($data[$key]);
            }
        }

        return $data;
    }
}
