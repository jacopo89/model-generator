<?php


namespace ModelGenerator\Bundle\ModelGeneratorBundle\Enum;


abstract class AbstractEnum implements EnumInterface
{
    protected const VALUES = [];

    public function isValid(): bool
    {
        return array_key_exists($this->getValue(), static::VALUES);
    }

    public static function getValues(): array
    {
        return array_keys(static::VALUES);
    }

    public function isSameEnum(EnumInterface $otherEnum): bool
    {
        return get_class($this) === get_class($otherEnum) && $this->getValue() === $otherEnum->getValue();
    }
}
