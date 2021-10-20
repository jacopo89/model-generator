<?php

declare(strict_types=1);

namespace ModelGenerator\Bundle\ModelGeneratorBundle\Resources\Listing\Repository;

use Doctrine\Persistence\ManagerRegistry;

class GenericListingRepository extends AbstractRepository implements ListingRepositoryInterface
{
    private string $class;

    public function __construct(ManagerRegistry $registry, string $class)
    {
        $this->class = $class;

        parent::__construct($registry, $class);
    }

    public function getResourceName(): string
    {
        return call_user_func([$this->class, 'getResourceName']);
    }

    protected function getLabelField(): string
    {
        return call_user_func([$this->class, 'getDefaultOptionText']);
    }
}
