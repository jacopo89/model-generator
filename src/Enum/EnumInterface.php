<?php


namespace ModelGenerator\Bundle\ModelGeneratorBundle\Enum;


interface EnumInterface
{
    public function getValue();
    public function getLabel();
    public function isValid(): bool;
    public static function getValues(): array;
}
