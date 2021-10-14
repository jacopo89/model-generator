<?php


namespace ModelGenerator\Bundle\ModelGeneratorBundle\ModelGenerator;


use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Annotations\Reader;
use ReflectionClass;
use ReflectionProperty;
use Symfony\Component\Serializer\Annotation\Groups;

class ResourceService
{

    private Reader $annotationReader;
    private ResourceProvider $resourceProvider;

    private const FILE_ENTITY = "App\Entity\File";

    public function __construct(Reader $reader, ResourceProvider $resourceProvider)
    {
        $this->annotationReader = $reader;
        $this->resourceProvider = $resourceProvider;
    }


    public function resourceAnalyzer(ResourceInterface $resource){
        $outputResource = new Resource();
        $resourceClass = new ReflectionClass($resource);

        $info = $this->annotationReader->getClassAnnotation($resourceClass, ApiResource::class);

        if($info instanceof ApiResource){
            $itemOperations = $info->itemOperations ?? [];
            $collectionOperations = $info->collectionOperations ?? [];
            $operations = array_merge($itemOperations,$collectionOperations);
            foreach ($operations as $operationName => $singleOperation){
                $operation = new Operation();
                $normalizationContext = $singleOperation["normalization_context"] ?? ["groups"=> []];
                $denormalizationContext = $singleOperation["denormalization_context"] ?? ["groups"=> []] ;

                $normalizationGroups = $normalizationContext["groups"];
                $denormalizationGroups = $denormalizationContext["groups"];

                $model = $this->generateModel($normalizationGroups, $denormalizationGroups, $resource);
                $operation->setModel($model);
                $operation->setName($operationName);
                $operation->setMethod($singleOperation["method"]);
                $outputResource->addOperation($operation);
            }
        }

        $outputResource->setTitle($resource->getResourceTitle());
        $outputResource->setResourceName($resource->getResourceName());

        return $outputResource;
    }

    private function subResourceAnalyzer($normalizationGroups, $denormalizationGroups, ResourceInterface $resource): SubResource
    {

        $outputResource = new SubResource();
        $model = $this->generateModel($normalizationGroups, $denormalizationGroups, $resource);
        $outputResource->setModel($model);

        $outputResource->setTitle($resource->getResourceTitle());
        $outputResource->setResourceName($resource->getResourceName());

        return $outputResource;
    }

    private function generateModel($normalizationGroups, $denormalizationGroups, $resource): Model
    {
        $resourceClass = new ReflectionClass($resource);
        $properties = $resourceClass->getProperties();

        $model = new Model();
        foreach ($properties as $property) {
            if(!$this->checkPropertyGroups($property, $normalizationGroups, $denormalizationGroups)) continue;
            $model->addPropertyModel($this->getPropertyModel($property, $normalizationGroups, $denormalizationGroups, $resource));
        }
        return $model;
    }

    private function getPropertyName(ReflectionProperty $property): string
    {
        $serializedAnnotation = $this->annotationReader->getPropertyAnnotation($property,  \Symfony\Component\Serializer\Annotation\SerializedName::class );
        if($serializedAnnotation)
            return $serializedAnnotation->getSerializedName();
        return $property->getName();
    }

    private function checkPropertyGroups($property, $normalizationGroups, $denormalizationGroups)
    {
        $groupClass = $this->annotationReader->getPropertyAnnotation($property, \Symfony\Component\Serializer\Annotation\Groups::class );
        if($groupClass instanceof Groups){
            $propertyGroups = array_map(function($item){ return strtolower($item);}, $groupClass->getGroups());
            $isNormalizable = sizeof(array_intersect($propertyGroups, $normalizationGroups)) > 0;
            $isDenormalizable = sizeof(array_intersect($propertyGroups, $denormalizationGroups)) > 0;

            return $isDenormalizable || $isNormalizable;
        }

        return false;
    }

    private function getPropertyModel(ReflectionProperty $property,  $normalizationGroups, $denormalizationGroups, ResourceInterface $resource): PropertyModel
    {
        $annotationClass = ResourceProperty::class;
        $annotation = $this->annotationReader->getPropertyAnnotation($property, $annotationClass);
        if ($annotation!==null) {
                $propertyModel= $this->generatePropertyModel($annotation,  $normalizationGroups, $denormalizationGroups, $resource);
                $propertyModel->setId($this->getPropertyName($property));
                $propertyModel->setLabel($this->getPropertyName($property));
        }else{
            throw new \Exception(sprintf("Property %s has no resource property annotation", $property->getName()));
        }
        return $propertyModel;
    }

    private function generatePropertyModel(ResourceProperty $annotation, $normalizationGroups, $denormalizationGroups, $resource): PropertyModel{
        //$json = $this->setWriteRead($property,$resource, $json, $type);
        switch($annotation->type){
            case "embedded_single":
            case "embedded_multiple":{
                $propertyModel = new PropertyModel();
                $resourceName = $this->getResourceStaticElements($annotation->targetClass)["resourceName"];
                $embeddedResource = $this->resourceProvider->get($resourceName);
                $propertyModel->setResource($this->subResourceAnalyzer($normalizationGroups, $denormalizationGroups, $embeddedResource));
                $propertyModel->setResourceName($resourceName);
            }break;

            case "reference":{
                $propertyModel = new PropertyModel();
                $resourceName = $this->getResourceStaticElements($annotation->targetClass)["resourceName"];
                $embeddedResource = $this->resourceProvider->get($resourceName);
                $optionText = $this->getResourceStaticElements($annotation->targetClass)["optionText"];
                $propertyModel->setResource($this->subResourceAnalyzer($normalizationGroups, $denormalizationGroups,$embeddedResource));
                $propertyModel->setResourceName($resourceName);
                $propertyModel->setOptionText($optionText);

            }break;
            case "enum_multiple":
            case "enum":{
                $propertyModel = new EnumPropertyModel();
                $propertyModel = $this->handleEnumAnnotation($annotation, $propertyModel);
            }break;
            default: {
                $propertyModel = new PropertyModel();
            }break;
        }
        if($annotation->nullable === false){
            $propertyModel->setValidators(["required"]);
            $propertyModel->setErrorMessages(["This field is required"]);
        }
        $propertyModel->setType($annotation->type);

        return $propertyModel;
    }

    private function getResourceStaticElements($resourceClassName): array
    {
        $resourceClass = new ReflectionClass($resourceClassName);
        try {
            return [
                "resourceName" => $resourceClass->getMethod("getResourceName")->invoke(null),
                "optionText" => $resourceClass->getMethod("getDefaultOptionText")->invoke(null)
            ];
        } catch (\ReflectionException $e) {
            dd($e);
        }
    }


    private function handleEnumAnnotation(ResourceProperty $annotation, EnumPropertyModel $propertyModel): EnumPropertyModel
    {

        if(isset($annotation->targetClass)){
            $targetClass = $annotation->targetClass;
        }else{
            dd($propertyModel);
        }

        $class = new ReflectionClass($targetClass);
        $variable = $annotation->optionsName;
        $options = $class->getConstant($variable);

        foreach ($options as $key => $value){
            $newOption = new EnumOption();
            $newOption->setId($key);
            $newOption->setLabel($value);
            $propertyModel->addOption($newOption);
        }

        return $propertyModel;

    }
}
