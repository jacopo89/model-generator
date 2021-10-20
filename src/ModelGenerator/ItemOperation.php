<?php


namespace ModelGenerator\Bundle\ModelGeneratorBundle\ModelGenerator;


class ItemOperation extends Operation
{
    private string $operationType = "item";

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
