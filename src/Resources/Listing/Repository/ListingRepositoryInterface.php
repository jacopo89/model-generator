<?php

declare(strict_types=1);

namespace ModelGenerator\Bundle\ModelGeneratorBundle\Resources\Listing\Repository;

use ModelGenerator\Bundle\ModelGeneratorBundle\Resources\Listing\Model\ResourceListingCollection;

interface ListingRepositoryInterface
{
    public function getResourceName(): string;
    public function getListing(array $searchterms = []): ResourceListingCollection;
}
