<?php


namespace ModelGenerator\Bundle\ModelGeneratorBundle\ModelGenerator;


use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\AbstractContextAwareFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use Doctrine\ORM\QueryBuilder;

class ArrayFilter extends AbstractContextAwareFilter
{
    protected function filterProperty(string $property, $value, QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, string $operationName = null)
    {
        if (
            !$this->isPropertyEnabled($property, $resourceClass) ||
            !$this->isPropertyMapped($property, $resourceClass)
        ) {
            return;
        }
        $parameterName = $queryNameGenerator->generateParameterName($property);
        foreach ($value as $key => $item)
        {
            $queryBuilder->andWhere("o.".$property . " LIKE :". $parameterName.$key);
            $queryBuilder->setParameter($parameterName.$key, '%"'.$item.'"%');
        }

    }

    public function getDescription(string $resourceClass): array
    {
        return [];
    }
}
