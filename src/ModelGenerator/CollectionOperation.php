<?php


namespace ModelGenerator\Bundle\ModelGeneratorBundle\ModelGenerator;


class CollectionOperation extends Operation
{
    private string $operationType = "collection";

    /**
     * @return string
     */
    public function getOperationType(): string
    {
        return $this->operationType;
    }

    public function jsonSerialize()
    {
        return [
            "name" => $this->name,
            "method" => $this->method,
            "model" => $this->model,
            "operationType" => $this->operationType
        ];
    }
}
