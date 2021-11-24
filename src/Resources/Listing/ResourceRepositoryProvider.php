<?php

declare(strict_types=1);

namespace ModelGenerator\Bundle\ModelGeneratorBundle\Resources\Listing;

use ModelGenerator\Bundle\ModelGeneratorBundle\ModelGenerator\ResourceProvider;
use ModelGenerator\Bundle\ModelGeneratorBundle\Resources\Listing\Exception\ListingRepositoryAlreadyDefinedException;
use ModelGenerator\Bundle\ModelGeneratorBundle\Resources\Listing\Exception\UndefinedListingRepositoryException;
use ModelGenerator\Bundle\ModelGeneratorBundle\Resources\Listing\Repository\Factory\GenericListingRepositoryFactory;
use ModelGenerator\Bundle\ModelGeneratorBundle\Resources\Listing\Repository\ListingRepositoryInterface;

class ResourceRepositoryProvider
{
    /**
     * @var ListingRepositoryInterface[]
     */
    private array $repositories = [];

    /**
     * @param iterable $repositories
     *
     * @throws ListingRepositoryAlreadyDefinedException
     */
    public function __construct(
        iterable $repositories,
        GenericListingRepositoryFactory $genericListingRepositoryFactory,
        ResourceProvider $resourceProvider)
    {
        foreach ($repositories as $repository) {
            $resource = $repository->getResourceName();

            if (isset($this->repositories[$resource])) {
                throw ListingRepositoryAlreadyDefinedException::createFromResourceName($repository->getResourceName());
            }

            $this->repositories[$resource] = $repository;
        }

        foreach($resourceProvider->getResources() as $resource) {
            if (isset($this->repositories[$resource->getResourceName()])) {
                continue;
            }

            $this->repositories[$resource->getResourceName()] = $genericListingRepositoryFactory->create($resource);
        }
    }

    /**
     * @param string $resourceName
     * @return ListingRepositoryInterface
     *
     * @throws UndefinedListingRepositoryException
     */
    public function get(string $resourceName): ListingRepositoryInterface
    {
        if (!isset($this->repositories[$resourceName])) {
            throw UndefinedListingRepositoryException::createFromResourceName($resourceName);
        }

        return $this->repositories[$resourceName];
    }
}
