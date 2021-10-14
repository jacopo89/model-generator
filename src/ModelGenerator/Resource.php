<?php


namespace ModelGenerator\Bundle\ModelGeneratorBundle\ModelGenerator;


class Resource implements \JsonSerializable
{
    private string $title;
    private string $resourceName;

    /**
     * @var Operation[]
     */
    private $operations = [];

    /**
     * @return Operation[]
     */
    public function getOperations(): array
    {
        return $this->operations;
    }

    /**
     * @param Operation[] $operations
     */
    public function setOperations(array $operations): void
    {
        $this->operations = $operations;
    }


    public function addOperation(Operation $operation): void
    {
        $this->operations[] = $operation;
    }

    /**
     * @return string
     */
    public function getResourceName(): string
    {
        return $this->resourceName;
    }

    /**
     * @param string $resourceName
     */
    public function setResourceName(string $resourceName): void
    {
        $this->resourceName = $resourceName;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function jsonSerialize()
    {
        return [
            "operations" => $this->operations,
            "resourceName" => $this->resourceName,
            "title" => $this->title
        ];
    }

}
