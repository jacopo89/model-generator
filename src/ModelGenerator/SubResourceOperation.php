<?php


namespace ModelGenerator\Bundle\ModelGeneratorBundle\ModelGenerator;


class SubResourceOperation extends Operation
{
    private string $operationType;

    /**
     * @return string
     */
    public function getOperationType(): string
    {
        return $this->operationType;
    }

    /**
     * @param string $operationType
     */
    public function setOperationType(string $operationType): void
    {
        $this->operationType = $operationType;
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
