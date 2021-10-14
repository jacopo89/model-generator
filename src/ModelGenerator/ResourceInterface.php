<?php


namespace ModelGenerator\Bundle\ModelGeneratorBundle\ModelGenerator;


interface ResourceInterface
{
    public static function getResourceName(): string;
    public static function getResourceTitle(): string;
    public static function getDefaultOptionText(): string;
}
