<?php

declare(strict_types=1);

namespace ModelGenerator\Bundle\ModelGeneratorBundle\Resources\Listing\Repository\Factory;

use ModelGenerator\Bundle\ModelGeneratorBundle\Provider\ResourceInterface;
use ModelGenerator\Bundle\ModelGeneratorBundle\Resources\Listing\Repository\GenericListingRepository;
use Doctrine\Persistence\ManagerRegistry;

class GenericListingRepositoryFactory
{
    private ManagerRegistry $registry;

    public function __construct(ManagerRegistry $registry)
    {
       $this->registry = $registry;
    }

    public function create(ResourceInterface $resource): GenericListingRepository
    {
        return new GenericListingRepository($this->registry, get_class($resource));
    }
}
