<?php


namespace ModelGenerator\Bundle\ModelGeneratorBundle\ModelGenerator;


class Model implements \JsonSerializable
{
    /**
     * @var PropertyModel[]
     */
    private $propertyModels = [];

    /**
     * @return PropertyModel[]
     */
    public function getPropertyModels(): array
    {
        return $this->propertyModels;
    }

    /**
     * @param PropertyModel[] $propertyModel
     */
    public function addPropertyModel(PropertyModel $propertyModel): void
    {
        $this->propertyModels[] = $propertyModel;
    }

    public function jsonSerialize()
    {
        $array = [];
        foreach ($this->propertyModels as $propertyModel){
            $property = [];
            $property[$propertyModel->getId()] = $propertyModel;
            $array[] = $property;
        }

        return $array;
    }
}
