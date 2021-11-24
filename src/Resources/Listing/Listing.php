<?php

declare(strict_types=1);

namespace ModelGenerator\Bundle\ModelGeneratorBundle\Resources\Listing;

use ModelGenerator\Bundle\ModelGeneratorBundle\Resources\Listing\Exception\UndefinedListingRepositoryException;
use ModelGenerator\Bundle\ModelGeneratorBundle\Resources\Listing\Model\ResourceListingCollection;

class Listing
{
    private ResourceRepositoryProvider $provider;

    public function __construct(ResourceRepositoryProvider $provider)
    {
        $this->provider = $provider;
    }

    public function getListing(string $resourceName, array $searchTerms = []): ?ResourceListingCollection
    {
        try {
            $repository = $this->provider->get($resourceName);

            return $repository->getListing($searchTerms);
        } catch (UndefinedListingRepositoryException $e) {

        }

        return null;
    }
}
