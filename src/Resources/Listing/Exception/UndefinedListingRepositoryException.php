<?php

declare(strict_types=1);

namespace ModelGenerator\Bundle\ModelGeneratorBundle\Resources\Listing\Exception;

class UndefinedListingRepositoryException extends \Exception
{
    public static function createFromResourceName(string $resourceName): self
    {
        return new self(sprintf('Repository for resource "%s" not found', $resourceName));
    }
}
