<?php

declare(strict_types=1);

namespace ModelGenerator\Bundle\ModelGeneratorBundle\Resources\Listing\Service;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Serializer;

class PropertiesSerializer
{
    private SerializerInterface $serializer;

    public function __construct()
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new PropertyNormalizer()];

        $this->serializer = new Serializer($normalizers, $encoders);
    }

    public function json($object): string
    {
        return $this->serializer->serialize($object, 'json');
    }
}
