<?php

declare(strict_types=1);

namespace ModelGenerator\Bundle\ModelGeneratorBundle\Resources\Listing\Repository;

use ModelGenerator\Bundle\ModelGeneratorBundle\Resources\Listing\Model\ResourceListing;
use ModelGenerator\Bundle\ModelGeneratorBundle\Resources\Listing\Model\ResourceListingCollection;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

abstract class AbstractRepository extends ServiceEntityRepository
{
    protected function getIdField(): string
    {
        return 'id';
    }

    abstract protected function getLabelField(): string;

    public function getListing(string $searchTerm = null): ResourceListingCollection
    {
        $qb = $this->createQueryBuilder('p')
            ->select(sprintf('NEW %s(p.%s, p.%s)', ResourceListing::class, $this->getIdField(), $this->getLabelField()));

        if (!empty($searchTerm)) {
            $qb
                ->andWhere(sprintf('p.%s LIKE :searchTerm', $this->getLabelField()))
                ->setParameter('searchTerm', '%' . $searchTerm . '%');
        }

        return new ResourceListingCollection($qb->getQuery()->getResult());
    }
}
