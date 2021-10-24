<?php


namespace ModelGenerator\Bundle\ModelGeneratorBundle\Controller;


use ModelGenerator\Bundle\ModelGeneratorBundle\ModelGenerator\ResourceProvider;
use ModelGenerator\Bundle\ModelGeneratorBundle\ModelGenerator\ResourceService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ResourceController
{
    /**
 * @Route("/resources", methods={"GET"}, name="get-resources")
 * @param ResourceProvider $resourceProvider
 * @param ResourceService $resourceService
 * @return Response
 */
    public function getResources(ResourceProvider $resourceProvider, ResourceService $newResourceService): Response
    {
        $resources = $resourceProvider->getResources();
        $results = [];

        foreach ($resources as $resource) {
            $result = $newResourceService->resourceAnalyzer($resource);
            $results[$resource->getResourceName()] = $result;
        }
        return new Response(json_encode($results));
    }


    /**
     * @Route("/resource/{name}", methods={"GET"}, name="get-resource")
     * @param ResourceProvider $resourceProvider
     * @param ResourceService $resourceService
     * @param $name
     * @return Response
     */
    public function getResource(ResourceProvider $resourceProvider, ResourceService $resourceService, $name): Response
    {
        $resource = $resourceProvider->get($name);
        $result = $resourceService->resourceAnalyzer($resource);
        return new Response(json_encode($result));
    }

}
