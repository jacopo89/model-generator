<?php

declare(strict_types=1);

namespace ModelGenerator\Bundle\ModelGeneratorBundle\Resources\Listing\Exception;

class ListingRepositoryAlreadyDefinedException extends \Exception
{
    public static function createFromResourceName(string $resourceName): self
    {
        return new self(sprintf('Repository for resource "%s" already defined', $resourceName));
    }
}
