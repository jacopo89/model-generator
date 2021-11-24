<?php

declare(strict_types=1);

namespace ModelGenerator\Bundle\ModelGeneratorBundle\Controller;

use ModelGenerator\Bundle\ModelGeneratorBundle\Resources\Listing\Listing;
use ModelGenerator\Bundle\ModelGeneratorBundle\Resources\Listing\Model\ResourceListingCollection;
use ModelGenerator\Bundle\ModelGeneratorBundle\Resources\Listing\Service\PropertiesSerializer;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("api/resources")
 */
class ResourceListingController
{
    /**
     * @Route("/listing/{resource}", methods={"GET"}, name="resources_listing")
     * @param string $resource
     * @param Listing $listing
     * @param PropertiesSerializer $serializer
     * @param Request $request
     * @return Response
     */
    public function listings(string $resource, Listing $listing, PropertiesSerializer $serializer, Request $request): Response
    {
        $searchTerms = json_decode($request->getContent(), true);
        $listingCollection = $listing->getListing($resource, $searchTerms);

        if($listingCollection instanceof ResourceListingCollection) {
            return new JsonResponse(
                $serializer->json($listingCollection->getResourcesListing()),
                Response::HTTP_OK,
                [],
                true);
        }

        throw new NotFoundHttpException();
    }

    /**
     * @Route("/listings", methods={"POST"}, name="resources_listings")
     * @param Listing $listing
     * @param PropertiesSerializer $serializer
     * @param Request $request
     * @return Response
     */
    public function listingsBlock(Listing $listing, PropertiesSerializer $serializer, Request $request): Response
    {
        $content = json_decode($request->getContent(), true);
        $resources = $content["resources"];
        $jsonResponse = [];
        foreach($resources as $resourceName => $resourceSearchTerms){
            if(is_string($resourceName)){
                $listingCollection = $listing->getListing($resourceName, $resourceSearchTerms);
                if($listingCollection instanceof ResourceListingCollection) {
                    $jsonResponse[$resourceName] = $listingCollection->getResourcesListing();
                    continue;
                }
                throw new NotFoundHttpException();
            }
            throw new BadRequestException("Resources should contain an array of strings");
        }
        return new JsonResponse(
            $serializer->json($jsonResponse),
            Response::HTTP_OK,
            [],
            true);


    }
}
