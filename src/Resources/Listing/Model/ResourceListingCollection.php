<?php

declare(strict_types=1);

namespace ModelGenerator\Bundle\ModelGeneratorBundle\Resources\Listing\Model;

class ResourceListingCollection
{
    /**
     * @var ResourceListing[]
     */
    private array $resourcesListing;

    /**
     * @param ResourceListing[] $resourceListings
     */
    public function __construct(array $resourceListings)
    {
        $this->resourcesListing = $resourceListings;
    }

    /**
     * @return ResourceListing[]
     */
    public function getResourcesListing(): array
    {
        return $this->resourcesListing;
    }
}
